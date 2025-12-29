<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use App\Mail\ReservationApproved; // Onay maili sınıfımız
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days'; // Takvim ikonu
    protected static ?string $navigationLabel = 'Rezervasyonlar';
    protected static ?string $pluralModelLabel = 'Masa Rezervasyonları';
    protected static ?string $navigationGroup = 'Müşteri İlişkileri';

    // Rezervasyonların admin panelinden manuel oluşturulmasını (Create) kapatıyoruz.
    // Çünkü rezervasyonlar siteden gelmeli. (İstersen açabilirsin)
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
                    ->date('d.m.Y') // Gün.Ay.Yıl formatı
                    ->sortable(),

                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Saat')
                    ->sortable(),

                // Durum Rozeti (Renkli)
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
                        'pending' => 'warning', // Sarı
                        'approved' => 'success', // Yeşil
                        'declined' => 'danger',  // Kırmızı
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Talep Tarihi')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc') // En yeniler en üstte
            ->actions([
                // --- ÖZEL ONAY BUTONU ---
                Tables\Actions\Action::make('approve')
                    ->label('Onayla')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Reservation $record) => $record->status === 'pending') // Sadece bekleyenlerde görünsün
                    ->requiresConfirmation()
                    ->modalHeading('Rezervasyonu Onayla')
                    ->modalDescription('Rezervasyon onaylanacak ve müşteriye bilgilendirme e-postası gönderilecektir. Emin misiniz?')
                    ->modalSubmitActionLabel('Evet, Onayla ve Mail Gönder')
                    ->action(function (Reservation $record) {
                        // 1. Durumu güncelle
                        $record->update(['status' => 'approved']);

                        // 2. Mail Gönder
                        try {
                            Mail::to($record->email)->send(new ReservationApproved($record));

                            Notification::make()
                                ->title('Rezervasyon Onaylandı')
                                ->body('Müşteriye onay maili başarıyla gönderildi.')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Hata')
                                ->body('Onaylandı fakat mail gönderilemedi. Mail ayarlarınızı kontrol edin.')
                                ->warning()
                                ->send();
                        }
                    }),

                // Reddet Butonu
                Tables\Actions\Action::make('decline')
                    ->label('Reddet')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Reservation $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Reservation $record) {
                        $record->update(['status' => 'declined']);
                        Notification::make()->title('Rezervasyon reddedildi.')->danger()->send();
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
            // 'create' => Pages\CreateReservation::route('/create'), // Kapattığımız için gerek yok
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}