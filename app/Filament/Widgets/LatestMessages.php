<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContactMessageResource; 
use App\Models\ContactMessage;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestMessages extends BaseWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Son İletişim Mesajları';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()->take(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Gönderen')
                    ->weight('bold')
                    // HATA DÜZELTİLDİ: ': string' yerine ': ?string' yaptık. (Email boşsa hata vermez)
                    ->description(fn (ContactMessage $record): ?string => $record->email), 

                Tables\Columns\TextColumn::make('subject')
                    ->label('Konu')
                    ->limit(40)
                    // HATA DÜZELTİLDİ: ': string' yerine ': ?string' yaptık. (Konu boşsa hata vermez)
                    ->tooltip(fn (ContactMessage $record): ?string => $record->subject),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('İncele')
                    ->icon('heroicon-m-eye')
                    ->color('gray')
                    ->url(fn (ContactMessage $record): string => ContactMessageResource::getUrl('edit', ['record' => $record])),
            ])
            ->headerActions([
                Tables\Actions\Action::make('all')
                    ->label('Gelen Kutusuna Git')
                    ->icon('heroicon-o-inbox-arrow-down')
                    ->url(fn () => ContactMessageResource::getUrl('index')),
            ])
            ->paginated(false);
    }
}