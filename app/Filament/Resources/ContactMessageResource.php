<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope'; // Zarf ikonu
    protected static ?string $navigationLabel = 'Gelen Mesajlar';
    protected static ?string $pluralModelLabel = 'İletişim Mesajları';

    // Mesajlar üzerinde değişiklik yapılmasın, sadece görüntülensin diye
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
                        Section::make('Gönderen Bilgileri')
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
                                    ->readonly(),
                                Forms\Components\TextInput::make('phone')
                                    ->label('Telefon')
                                    ->readonly(),
                            ])->columnSpan(4),

                        Section::make('Mesaj İçeriği')
                            ->schema([
                                Forms\Components\Textarea::make('message')
                                    ->label('Mesaj')
                                    ->rows(5)
                                    ->readonly()
                                    ->columnSpanFull(),
                                
                                Forms\Components\Toggle::make('is_read')
                                    ->label('Okundu Olarak İşaretle')
                                    ->columnSpanFull(),
                            ])->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fname')
                    ->label('Ad Soyad')
                    ->formatStateUsing(fn ($record) => $record->fname . ' ' . $record->lname)
                    ->searchable(['fname', 'lname']),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('E-Posta')
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Okundu')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(), // Detay Görüntüleme
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            // Create ve Edit sayfalarına gerek duymadık, ViewAction modal içinde açılır veya edit route'u view olarak kullanılabilir.
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}