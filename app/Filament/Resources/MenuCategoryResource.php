<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuCategoryResource\Pages;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class MenuCategoryResource extends Resource
{
    protected static ?string $model = MenuCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group'; // Kategori grubu ikonu
    protected static ?string $navigationLabel = 'Menü Kategorileri';
    protected static ?string $navigationGroup = 'Menü & Ürünler'; // Gruplama

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Görsel ve Durum')
                                    ->description('Kategori bannerı ve yayın durumu.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('DİKKAT: Pasife alırsanız, bu kategoriye bağlı ürünler de menüde gözükmez.')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('img')
                                            ->label('Kategori Banner')
                                            ->image()
                                            ->disk('uploads') // Uploads diski kullanılıyor
                                            ->directory('menu_categories') // public/uploads/menu_categories içine
                                            ->imageEditor()
                                            ->helperText('Boyut: 1920x768 px. Sayfa üstünde geniş banner olarak kullanılır.')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Kategori Bilgileri')
                                    ->description('Menüde görünecek başlık ve açıklamalar.')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Kategori Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->helperText('Örn: Başlangıçlar, Ana Yemekler...')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL Bağlantısı (Slug)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Otomatik oluşturulur.')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama')
                                            ->helperText('Kategori sayfasında başlığın altında yer alacak tanıtım yazısı.')
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
                    ->label('Banner')
                    ->disk('uploads') // Tabloda göstermek için disk belirtildi
                    ->height(50),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

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
            'index' => Pages\ListMenuCategories::route('/'),
            'create' => Pages\CreateMenuCategory::route('/create'),
            'edit' => Pages\EditMenuCategory::route('/{record}/edit'),
        ];
    }
}