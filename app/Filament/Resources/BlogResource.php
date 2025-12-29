<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Blog Yazıları';
    protected static ?string $navigationGroup = 'Blog Yönetimi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Yayın ve Kategori')
                                    ->description('Görsel, kategori ve etiket ayarları.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('Yazıyı geçici olarak gizlemek için kapatabilirsiniz.')
                                            ->columnSpanFull(),

                                        // Kategori Seçimi (Hızlı ekleme özellikli)
                                        Forms\Components\Select::make('blog_category_id')
                                            ->label('Kategori')
                                            ->relationship('blogCategory', 'title')
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
                                            ->required()
                                            ->helperText('Yazının ait olduğu kategori.')
                                            ->columnSpanFull(),

                                        Forms\Components\TagsInput::make('tags')
                                            ->label('Etiketler (Tags)')
                                            ->separator(',')
                                            ->helperText('Enter tuşuna basarak yeni etiket ekleyebilirsiniz.')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('img')
                                            ->label('Kapak Görseli')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('blogs') // public/uploads/blogs içine
                                            ->imageEditor()
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Blog İçeriği')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Blog Başlığı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL (Slug)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('İçerik')
                                            ->helperText('Blog yazısının tamamını buraya giriniz.')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('SEO Ayarları')
                                    ->description('Google ve arama motorları için ayarlar.')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->label('Meta Başlık')
                                            ->placeholder('Varsayılan olarak yazı başlığı kullanılır.')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('meta_desc')
                                            ->label('Meta Açıklama')
                                            ->rows(2)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('meta_keywords')
                                            ->label('Anahtar Kelimeler')
                                            ->helperText('Virgül ile ayırınız.')
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
                    ->label('Kapak')
                    ->disk('uploads') // Tabloda göstermek için diski belirttik
                    ->height(50),

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('blogCategory.title')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategori')
                    ->relationship('blogCategory', 'title'),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}