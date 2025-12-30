<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?string $navigationLabel = 'Menü Ürünleri';
    protected static ?string $navigationGroup = 'Menü & Ürünler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Durum ve Kategori')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->inline(false),

                                        Forms\Components\Select::make('menu_category_id')
                                            ->label('Kategori')
                                            ->relationship('menuCategory', 'title')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Kategori Adı')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')->required(),
                                            ]),
                                    ]),

                                Section::make('Fiyatlandırma')
                                    ->description('Boyutlara göre fiyatları belirleyin.')
                                    ->schema([
                                        Forms\Components\Toggle::make('has_sizes')
                                            ->label('Boyutlu Ürün (S/M/L)')
                                            ->helperText('Açıksa Orta ve Büyük boy fiyatları girilebilir.')
                                            ->live() // Değişikliği anlık algılaması için
                                            ->columnSpanFull(),

                                        // Tekli Fiyat veya Küçük Boy Fiyatı
                                        Forms\Components\TextInput::make('price')
                                            ->label(fn (Forms\Get $get) => $get('has_sizes') ? 'Küçük Boy (S)' : 'Standart Fiyat')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->required()
                                            ->columnSpan(fn (Forms\Get $get) => $get('has_sizes') ? 1 : 'full'),

                                        // Orta Boy (Sadece has_sizes aktifse görünür)
                                        Forms\Components\TextInput::make('price_medium')
                                            ->label('Orta Boy (M)')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->visible(fn (Forms\Get $get) => $get('has_sizes'))
                                            ->columnSpan(1),

                                        // Büyük Boy (Sadece has_sizes aktifse görünür)
                                        Forms\Components\TextInput::make('price_large')
                                            ->label('Büyük Boy (L)')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->visible(fn (Forms\Get $get) => $get('has_sizes'))
                                            ->columnSpan(1),
                                    ])->columns(3), // İçerideki alanları 3 sütuna böler

                                Section::make('Medya')
                                    ->schema([
                                        Forms\Components\FileUpload::make('img')
                                            ->label('Ürün Görseli')
                                            ->image()
                                            ->disk('uploads')
                                            ->directory('menus')
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(5), // Sol kolonu biraz genişlettik (fiyatlar sığsın diye)

                        // --- SAĞ KOLON (7 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Ürün Bilgileri')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Ürün Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (URL)')
                                            ->required()
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama / İçindekiler'),
                                        
                                        Forms\Components\TextInput::make('likes')
                                            ->label('Başlangıç Beğeni Sayısı')
                                            ->numeric()
                                            ->default(0),
                                    ]),

                                Section::make('SEO')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title'),
                                        Forms\Components\Textarea::make('meta_desc')->rows(2),
                                        Forms\Components\TextInput::make('meta_keywords'),
                                    ]),
                            ])
                            ->columnSpan(7),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')
                    ->label('Görsel')
                    ->disk('uploads')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Ürün Adı')
                    ->searchable()
                    ->description(fn (Menu $record) => $record->has_sizes ? 'Boyutlu Ürün' : 'Standart'),

                Tables\Columns\TextColumn::make('menuCategory.title')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Fiyat (S/Std)')
                    ->money('TRY'),

                Tables\Columns\TextColumn::make('price_medium')
                    ->label('(M)')
                    ->money('TRY')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('price_large')
                    ->label('(L)')
                    ->money('TRY')
                    ->placeholder('-'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('menu_category_id')
                    ->label('Kategori')
                    ->relationship('menuCategory', 'title'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}