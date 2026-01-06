<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Hizmet ikonu
    protected static ?string $navigationLabel = 'Hizmetler';
    protected static ?string $navigationGroup = 'Kurumsal';
    protected static ?string $pluralModelLabel = 'Hizmetlerimiz';
    protected static ?string $label = 'Hizmet';

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
                                    ->description('Hizmet ikonu ve yayın ayarları.')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('Bu hizmeti sitede göstermek için açık bırakın.')
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('icon')
                                            ->label('Hizmet İkonu / Görseli')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('services') // public/uploads/services içine
                                            ->imageEditor()
                                            ->helperText('Hizmeti temsil eden ikon veya fotoğraf.')
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Hizmet Detayları')
                                    ->description('Hizmet başlığı ve açıklaması.')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Hizmet Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->helperText('Örn: Web Tasarım, Danışmanlık...')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('URL (Slug)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Otomatik oluşturulur.')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama')
                                            ->helperText('Hizmetin detaylı açıklaması.')
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
                Tables\Columns\ImageColumn::make('icon')
                    ->label('İkon')
                    ->disk('uploads') // Tabloda göstermek için disk belirtildi
                    ->height(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Hizmet Adı')
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}