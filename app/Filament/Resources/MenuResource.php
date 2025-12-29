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

    protected static ?string $navigationIcon = 'heroicon-o-cake'; // Menü ikonu
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
                                Section::make('Ürün Detayları')
                                    ->description('Fiyat, kategori ve görsel ayarları.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('Ürünü gizlemek için kapatabilirsiniz.')
                                            ->columnSpanFull(),

                                        // Hızlı kategori ekleme formu
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
                                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $state ? $set('slug', Str::slug($state)) : null),
                                                
                                                Forms\Components\TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                            ])
                                            ->helperText('Bu ürünün ait olduğu menü kategorisi.')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Fiyat')
                                            ->numeric()
                                            ->prefix('₺')
                                            ->default(0)
                                            ->helperText('Ürünün satış fiyatı.')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('likes')
                                            ->label('Beğeni Sayısı')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Manuel olarak beğeni sayısı girebilirsiniz.')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('img')
                                            ->label('Ürün Görseli')
                                            ->image()
                                            ->disk('uploads') // Uploads diski kullanılıyor
                                            ->directory('menus') // public/uploads/menus içine
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('İçerik')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Ürün Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (URL)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama / İçindekiler')
                                            ->helperText('Ürünün içeriği, malzemeleri vb.')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('SEO Ayarları')
                                    ->description('Arama motorları için özel tanımlamalar.')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->label('Meta Başlık')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('meta_desc')
                                            ->label('Meta Açıklama')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('meta_keywords')
                                            ->label('Anahtar Kelimeler')
                                            ->helperText('Virgül ile ayırarak giriniz.')
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
                Tables\Columns\ImageColumn::make('img')
                    ->label('Görsel')
                    ->disk('uploads') // Tabloda göstermek için diski belirttik
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Ürün Adı')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('menuCategory.title')
                    ->label('Kategori')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Fiyat')
                    ->money('TRY')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('menu_category_id')
                    ->label('Kategoriye Göre Filtrele')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
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