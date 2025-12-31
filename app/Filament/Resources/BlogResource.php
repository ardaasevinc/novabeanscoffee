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
                        Group::make()
                            ->schema([
                                Section::make('Yayın ve Kategori')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->columnSpanFull(),

                                        // DÜZELTİLDİ: relationship('category', ...)
                                        Forms\Components\Select::make('blog_category_id')
                                            ->label('Kategori')
                                            ->relationship('category', 'title')
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('title')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')->required(),
                                            ])
                                            ->required()
                                            ->columnSpanFull(),

                                        Forms\Components\TagsInput::make('tags')
                                            ->label('Etiketler')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('img')
                                            ->label('Kapak Görseli')
                                            ->image()
                                            ->disk('uploads')
                                            ->directory('blogs')
                                            ->columnSpanFull(),
                                    ]),
                            ])->columnSpan(4),

                        Group::make()
                            ->schema([
                                Section::make('Blog İçeriği')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn($operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('İçerik')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('SEO Ayarları')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title'),
                                        Forms\Components\Textarea::make('meta_desc'),
                                        Forms\Components\TextInput::make('meta_keywords'),
                                    ]),
                            ])->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('img')->disk('uploads'),
                Tables\Columns\TextColumn::make('title')->searchable()->limit(30),

                // DÜZELTİLDİ: category.title
                Tables\Columns\TextColumn::make('category.title')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // DÜZELTİLDİ: relationship('category', ...)
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'title'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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