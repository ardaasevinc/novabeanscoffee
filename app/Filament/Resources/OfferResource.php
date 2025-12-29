<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section; // Section bileşenini ekledik

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    // Menü ikonu
    protected static ?string $navigationIcon = 'heroicon-o-star';
    
    // Menüde görünecek isimler
    protected static ?string $navigationLabel = 'Neler Sunuyoruz?';
    protected static ?string $pluralModelLabel = 'Teklifler / Maddeler';
    protected static ?string $navigationGroup = 'Kurumsal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('İçerik Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Başlık')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Örn: VIP Yemek Odası'),

                        Forms\Components\Textarea::make('description')
                            ->label('Açıklama')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull() // Tam genişlik kaplasın
                            ->helperText('Akordiyon açıldığında gözükecek metin.'),
                    ]),

                Section::make('Ayarlar')
                    ->schema([
                        Forms\Components\TextInput::make('sort')
                            ->label('Sıralama')
                            ->numeric()
                            ->default(0)
                            ->helperText('Düşük numara en üstte görünür.'),

                        Forms\Components\Toggle::make('is_published')
                            ->label('Yayında')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Açıklama')
                    ->limit(50) // Tabloda çok yer kaplamasın diye kısaltıyoruz
                    ->tooltip(fn (Offer $record): string => $record->description), // Üzerine gelince tamamını göster

                Tables\Columns\TextColumn::make('sort')
                    ->label('Sıra')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort', 'asc') // Varsayılan olarak belirlediğin sıraya göre listele
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}