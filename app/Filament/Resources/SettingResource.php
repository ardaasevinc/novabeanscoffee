<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth'; // Ayarlar için uygun ikon
    protected static ?string $navigationLabel = 'Site Ayarları';

    protected static ?string $pluralModelLabel = 'Site Ayarları';

    protected static ?string $label = 'Genel Ayar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim): Görseller, Video ve Durum ---
                        Group::make()
                            ->schema([
                                Section::make('Medya ve Durum')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Logo')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('favicon')
                                            ->label('Favicon')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('icon_72x72')
                                            ->label('Icon 72x72')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('icon_192x192')
                                            ->label('Icon 192x192')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('icon_512x512')
                                            ->label('Icon 512x512')
                                            ->image()
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings')
                                            ->columnSpanFull(),

                                        Forms\Components\FileUpload::make('site_video')
                                            ->label('Site Tanıtım Videosu')
                                            ->disk('uploads') // Uploads diski
                                            ->directory('settings/videos')
                                            ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        // --- SAĞ KOLON (8 Birim): Genel Bilgiler ---
                        Group::make()
                            ->schema([
                                Section::make('Genel Ayarlar')
                                    ->schema([
                                        Forms\Components\TextInput::make('slogan')
                                            ->label('Slogan')
                                            ->columnSpanFull(),

                                        Forms\Components\ColorPicker::make('themecolor')
                                            ->label('Tema Rengi')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->label('E-Posta Adresi')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('phone')
                                            ->tel()
                                            ->label('Telefon Numarası')
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('address')
                                            ->label('Adres')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('map')
                                            ->label('Harita (Iframe Kodu)')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Sosyal Medya')
                                    ->schema([
                                        Forms\Components\TextInput::make('instagram_url')
                                            ->label('Instagram URL')
                                            ->prefix('https://')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('facebook_url')
                                            ->label('Facebook URL')
                                            ->prefix('https://')
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('x_url')
                                            ->label('X (Twitter) URL')
                                            ->prefix('https://')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('SEO & Footer')
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->label('Meta Başlık')
                                            ->columnSpanFull(),

                                        Forms\Components\Textarea::make('meta_desc')
                                            ->label('Meta Açıklama')
                                            ->rows(3)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('meta_keywords')
                                            ->label('Meta Anahtar Kelimeler')
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('footer_text')
                                            ->label('Footer Yazısı')
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
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('uploads'), // Tabloda göstermek için disk belirtildi

                Tables\Columns\TextColumn::make('slogan')
                    ->label('Slogan')
                    ->limit(50),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-Posta'),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Yayında')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Son Güncelleme')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}