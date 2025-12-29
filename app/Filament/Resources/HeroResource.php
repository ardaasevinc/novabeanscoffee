<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroResource\Pages;
use App\Models\Hero;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';
    protected static ?string $navigationLabel = 'Slider / Hero';

    public static function form(Form $form): Form
    {
        // Sistemdeki isimlendirilmiş route'ları alalım
        $routes = collect(Route::getRoutes()->getRoutesByName())
            ->keys()
            ->filter(fn($route) => !str_starts_with($route, 'filament.') && !str_starts_with($route, 'ignition.') && !str_starts_with($route, 'sanctum.'))
            ->mapWithKeys(fn($route) => [$route => $route])
            ->toArray();

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

                                        Forms\Components\FileUpload::make('image')
                                            ->label('Arkaplan Görseli')
                                            ->image()
                                            ->disk('uploads') // Uploads diskini kullan
                                            ->directory('heroes') // public/uploads/heroes içine kaydeder
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('video_url')
                                            ->label('Video URL')
                                            ->placeholder('Youtube vb. link')
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
                                            ->label('Başlık')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->required()
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (Sabit Link)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('sub_title')
                                            ->label('Alt Başlık')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Buton Ayarları')
                                    ->schema([
                                        Forms\Components\Select::make('left_btn')
                                            ->label('Sol Buton Linki (Route)')
                                            ->searchable()
                                            ->options($routes)
                                            ->columnSpanFull(),

                                        Forms\Components\Select::make('right_btn')
                                            ->label('Sağ Buton Linki (Route)')
                                            ->searchable()
                                            ->options($routes)
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
                Tables\Columns\ImageColumn::make('image')
                    ->label('Görsel')
                    ->disk('uploads'), // Tabloda göstermek için diski belirttik

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
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
            'index' => Pages\ListHeroes::route('/'),
            'create' => Pages\CreateHero::route('/create'),
            'edit' => Pages\EditHero::route('/{record}/edit'),
        ];
    }
}