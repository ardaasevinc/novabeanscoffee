<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ReservationResource;
use App\Models\Reservation;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestReservations extends BaseWidget
{
    // Widget'ın dashboard'daki sırası (1 en üst)
    protected static ?int $sort = 1; 
    
    // Genişlik ayarı (full = tam satır kaplar)
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Son Gelen Rezervasyonlar';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Sadece son 5 kaydı gösterelim
                Reservation::latest()->take(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('fname')
                    ->label('Müşteri')
                    ->formatStateUsing(fn ($record) => $record->fname . ' ' . $record->lname)
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon'),

                Tables\Columns\TextColumn::make('reservation_date')
                    ->label('Tarih')
                    ->date('d.m.Y'),

                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Saat'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'declined',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Bekliyor',
                        'approved' => 'Onaylandı',
                        'declined' => 'Reddedildi',
                        default => $state,
                    }),
            ])
            ->actions([
                // Satır üzerindeki işlem (Örn: Hızlı Onay)
                Tables\Actions\Action::make('edit')
                    ->label('Detay')
                    ->url(fn (Reservation $record): string => ReservationResource::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-pencil-square'),
            ])
            ->headerActions([
                // TABLONUN ÜSTÜNDEKİ "TÜMÜNE GİT" BUTONU
                Tables\Actions\Action::make('all')
                    ->label('Tüm Rezervasyonlara Git')
                    ->url(ReservationResource::getUrl('index')) // Resource index sayfasına link
                    ->icon('heroicon-o-arrow-right')
                    ->color('gray'),
            ])
            ->paginated(false); // Sayfalamayı kapat (Widget olduğu için)
    }
}