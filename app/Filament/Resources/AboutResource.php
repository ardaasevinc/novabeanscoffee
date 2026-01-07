<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutResource\Pages;
use App\Models\About;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;

class AboutResource extends Resource
{
    protected static ?string $model = About::class;
    protected static ?string $label = 'Hakkımızda';

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'Hakkımızda';
    protected static ?string $pluralModelLabel = 'Hakkımızda';

    public static function form(Form $form): Form
    {
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

                                Section::make('Özellik Listesi')
                                    ->description('Buraya istediğiniz kadar özellik ekleyebilirsiniz.')
                                    ->schema([
                                        Repeater::make('features')
                                            ->label('Özellikler')
                                            ->schema([
                                                Forms\Components\FileUpload::make('icon')
                                                    ->label('İkon / Görsel')
                                                    ->image()
                                                    ->disk('uploads') // Config'de tanımladığımız disk
                                                    ->directory('about') // uploads/about içine atar
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
                // JSON içindeki resimleri çekip tabloda gösteriyoruz
                Tables\Columns\ImageColumn::make('features_icons')
                    ->label('Özellik İkonları')
                    ->disk('uploads') // Tabloda da diski belirtmek şart
                    ->getStateUsing(function (About $record) {
                        // JSON array içindeki 'icon' anahtarlarını topluyoruz
                        if (is_array($record->features)) {
                            return collect($record->features)->pluck('icon')->filter()->toArray();
                        }
                        return [];
                    })
                    ->circular()
                    ->stacked() // Resimleri üst üste bindirerek gösterir
                    ->limit(3), // En fazla 3 tane göster, gerisine +1 yazar

                Tables\Columns\TextColumn::make('main_title')
                    ->label('Ana Başlık')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sub_title')
                    ->label('Alt Başlık')
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Güncellenme'),
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
            'index' => Pages\ListAbouts::route('/'),
            'create' => Pages\CreateAbout::route('/create'),
            'edit' => Pages\EditAbout::route('/{record}/edit'),
        ];
    }

        public static function canCreate(): bool
{
    
    return static::getModel()::count() < 1;
}
}