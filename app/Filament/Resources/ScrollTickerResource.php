<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScrollTickerResource\Pages;
use App\Models\ScrollTicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class ScrollTickerResource extends Resource
{
    protected static ?string $model = ScrollTicker::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone'; // Duyuru/Ticker ikon
    protected static ?string $navigationLabel = 'Kayan Yazılar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Medya ve Durum')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('icon')
                                            ->label('İkon / Görsel')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('tickers') // public/uploads/tickers içine
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('İçerik')
                                    ->schema([
                                        Forms\Components\TextInput::make('text')
                                            ->label('Duyuru Metni')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Detaylı Açıklama')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->label('İkon')
                    ->disk('uploads'), // Tabloda göstermek için disk belirtildi
                    
                Tables\Columns\TextColumn::make('text')
                    ->label('Metin')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
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
            'index' => Pages\ListScrollTickers::route('/'),
            'create' => Pages\CreateScrollTicker::route('/create'),
            'edit' => Pages\EditScrollTicker::route('/{record}/edit'),
        ];
    }
}