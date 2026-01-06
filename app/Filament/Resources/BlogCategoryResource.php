<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogCategoryResource\Pages;
use App\Models\BlogCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class BlogCategoryResource extends Resource
{
    protected static ?string $model = BlogCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-hashtag'; // Blog/Kategori ikonu
    protected static ?string $navigationLabel = 'Blog Kategorileri';
    protected static ?string $navigationGroup = 'Blog Yönetimi';
    protected static ?string $label = 'Kategori';

    protected static ?string $pluralModelLabel = 'Haber Kategorileri';
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
                                    ->description('Kategori görseli ve yayın ayarları.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('DİKKAT: Bu kategoriyi gizlerseniz, ilgili blog yazıları da filtrelenebilir.')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('img')
                                            ->label('Kategori Görseli')
                                            ->image()
                                            ->disk('uploads') // Uploads diski tanımlandı
                                            ->directory('blog_categories') // public/uploads/blog_categories altına kaydeder
                                            ->imageEditor()
                                            ->helperText('Liste sayfalarında görünecek kapak görseli.')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Kategori İçeriği')
                                    ->description('Blog kategorisi için başlık ve açıklama giriniz.')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Kategori Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->helperText('Örn: Teknoloji, Yaşam, Tarifler...')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL (Slug)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Tarayıcı adres çubuğunda görünecek isim.')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Kısa Açıklama')
                                            ->helperText('Bu kategori sayfasında üstte görünecek tanıtım metni.')
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
                    ->disk('uploads') // Tabloda göstermek için disk belirtildi
                    ->height(50),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Link')
                    ->icon('heroicon-m-link')
                    ->color('gray')
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),

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
            'index' => Pages\ListBlogCategories::route('/'),
            'create' => Pages\CreateBlogCategory::route('/create'),
            'edit' => Pages\EditBlogCategory::route('/{record}/edit'),
        ];
    }
}