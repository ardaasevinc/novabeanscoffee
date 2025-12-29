<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle'; // Soru işareti ikonu
    protected static ?string $navigationLabel = 'S.S.S.';
    protected static ?string $pluralModelLabel = 'Sıkça Sorulan Sorular';
    protected static ?string $navigationGroup = 'Kurumsal';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim): Durum ve Sıralama ---
                        Group::make()
                            ->schema([
                                Section::make('Yayın Ayarları')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->onColor('success')
                                            ->offColor('danger'),

                                        Forms\Components\TextInput::make('sort')
                                            ->label('Sıralama')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('Düşük sayı en üstte gözükür.'),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim): Soru ve Cevap ---
                        Group::make()
                            ->schema([
                                Section::make('Soru Detayları')
                                    ->schema([
                                        Forms\Components\TextInput::make('question')
                                            ->label('Soru')
                                            ->required()
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('answer')
                                            ->label('Cevap')
                                            ->required()
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
                Tables\Columns\TextColumn::make('question')
                    ->label('Soru')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('Sıra')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort', 'asc') // Varsayılan olarak sıraya göre listele
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}