<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseResource\Pages;
use App\Models\WhyChoose;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class WhyChooseResource extends Resource
{
    protected static ?string $model = WhyChoose::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationLabel = 'Neden Biz?';

    public static function form(Form $form): Form
    {
        // Route listesini hazırlıyoruz
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
                                Section::make('Durum')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Sabit İçerik')
                                    ->schema([
                                        Forms\Components\TextInput::make('main_title')
                                            ->label('Ana Başlık')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('sub_title')
                                            ->label('Alt Başlık')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Buton Ayarları')
                                    ->schema([
                                        Forms\Components\TextInput::make('btn_text')
                                            ->label('Buton Yazısı')
                                            ->columnSpanFull(),

                                        Forms\Components\Select::make('btn_url')
                                            ->label('Buton Linki (Route)')
                                            ->searchable()
                                            ->options($routes)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Maddeler (Foreach)')
                                    ->description('Neden biz sorusunun cevaplarını buraya ekleyin.')
                                    ->schema([
                                        Repeater::make('items')
                                            ->label('Maddeler')
                                            ->schema([
                                                Forms\Components\FileUpload::make('icon')
                                                    ->label('İkon')
                                                    ->image()
                                                    ->disk('uploads') // Uploads diski
                                                    ->directory('why_choose') // public/uploads/why_choose içine
                                                    ->columnSpanFull(),

                                                Forms\Components\TextInput::make('title')
                                                    ->label('Başlık')
                                                    ->required()
                                                    ->columnSpanFull(),

                                                Forms\Components\RichEditor::make('desc')
                                                    ->label('Açıklama')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
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
                Tables\Columns\TextColumn::make('main_title')
                    ->label('Başlık')
                    ->searchable(),
                Tables\Columns\TextColumn::make('btn_text')
                    ->label('Buton')
                    ->placeholder('-'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Güncelleme'),
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
            'index' => Pages\ListWhyChooses::route('/'),
            'create' => Pages\CreateWhyChoose::route('/create'),
            'edit' => Pages\EditWhyChoose::route('/{record}/edit'),
        ];
    }
}