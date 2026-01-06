<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Mail\ReservationApproved;
use App\Mail\ReservationDeclined; // EKLENDİ: Ret maili sınıfı
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // EKLENDİ: Hata logları için
use Filament\Notifications\Notification;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Rezervasyonlar';
    protected static ?string $pluralModelLabel = 'Masa Rezervasyonları';
    protected static ?string $navigationGroup = 'Müşteri İlişkileri';
    protected static ?string $label = 'Rezervasyon';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // Sol Kolon: Müşteri Bilgileri
                        Section::make('Müşteri Bilgileri')
                            ->schema([
                                Forms\Components\TextInput::make('fname')
                                    ->label('Ad')
                                    ->readonly(),
                                Forms\Components\TextInput::make('lname')
                                    ->label('Soyad')
                                    ->readonly(),
                                Forms\Components\TextInput::make('email')
                                    ->label('E-Posta')
                                    ->email()
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->readonly(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Telefon')
                                    ->prefixIcon('heroicon-m-phone')
                                    ->readonly(),
                            ])
                            ->columnSpan(6),

                        // Sağ Kolon: Rezervasyon Detayları
                        Section::make('Rezervasyon Detayları')
                            ->schema([
                                Forms\Components\DatePicker::make('reservation_date')
                                    ->label('Tarih')
                                    ->readonly(),
                                Forms\Components\TextInput::make('reservation_time')
                                    ->label('Saat')
                                    ->readonly(),
                                Forms\Components\Select::make('status')
                                    ->label('Durum')
                                    ->options([
                                        'pending' => 'Bekliyor',
                                        'approved' => 'Onaylandı',
                                        'declined' => 'Reddedildi',
                                    ])
                                    ->native(false)
                                    ->required(),
                            ])
                            ->columnSpan(6),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fname')
                    ->label('Müşteri')
                    ->formatStateUsing(fn ($record) => $record->fname . ' ' . $record->lname)
                    ->searchable(['fname', 'lname'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),

                Tables\Columns\TextColumn::make('reservation_date')
                    ->label('Tarih')
                    ->date('d.m.Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Saat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Onay Bekliyor',
                        'approved' => 'Onaylandı',
                        'declined' => 'Reddedildi',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'declined' => 'danger',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Talep Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // --- ONAY BUTONU ---
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn(Reservation $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Rezervasyonu Onayla')
                    ->modalDescription('Rezervasyon onaylanacak ve müşteriye bilgilendirme e-postası gönderilecektir. Emin misiniz?')
                    ->modalSubmitActionLabel('Evet, Onayla')
                    ->action(function (Reservation $record) {
                        $record->update(['status' => 'approved']);

                        try {
                            Mail::to($record->email)->send(new ReservationApproved($record));

                            Notification::make()
                                ->title('Rezervasyon Onaylandı')
                                ->body('Müşteriye onay maili gönderildi.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Log::error('Onay Mail Hatası: ' . $e->getMessage());
                            Notification::make()
                                ->title('Mail Gönderilemedi')
                                ->body('Durum güncellendi ancak mail hatası oluştu.')
                                ->warning()
                                ->send();
                        }
                    }),

                // --- REDDET BUTONU (GÜNCELLENDİ) ---
                Tables\Actions\Action::make('decline')
                    ->label('Reddet')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Reservation $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Rezervasyonu Reddet')
                    ->modalDescription('Bu işlem geri alınamaz ve müşteriye ret maili gönderilir. Devam etmek istiyor musunuz?')
                    ->modalSubmitActionLabel('Evet, Reddet')
                    ->action(function (Reservation $record) {
                        // 1. Durumu güncelle
                        $record->update(['status' => 'declined']);

                        // 2. Mail Gönder (EKLENEN KISIM)
                        try {
                            Mail::to($record->email)->send(new ReservationDeclined($record));

                            Notification::make()
                                ->title('Rezervasyon Reddedildi')
                                ->body('Müşteriye ret bilgilendirmesi gönderildi.')
                                ->success() // İşlem başarılı (Kırmızı buton ama işlem başarılı olduğu için success notification uygun)
                                ->send();
                        } catch (\Exception $e) {
                            Log::error('Ret Maili Hatası (ID: ' . $record->id . '): ' . $e->getMessage());

                            Notification::make()
                                ->title('Mail Gönderilemedi')
                                ->body('Durum reddedildi olarak güncellendi ancak mail iletilemedi. Lütfen logları kontrol edin.')
                                ->warning()
                                ->send();
                        }
                    }),

                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}