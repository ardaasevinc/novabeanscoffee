<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
// Import İşlemi İçin Gerekli Sınıflar
use App\Imports\MenuImport;
use Maatwebsite\Excel\Facades\Excel;
// Export İşlemi İçin Gerekli Sınıflar (pxlrbt paketi)
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
// Storage import'u kaldırıldı.

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?string $navigationLabel = 'Menü Ürünleri';
    protected static ?string $navigationGroup = 'Menü & Ürünler';
    protected static ?string $pluralModelLabel = 'Menü';
    protected static ?string $label = 'Ürün';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(12)
                    ->schema([
                        // --- SOL KOLON (4 Birim) ---
                        Group::make()
                            ->schema([
                                Section::make('Ürün Detayları')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('Yayında')
                                            ->default(true)
                                            ->helperText('Ürünü gizlemek için kapatabilirsiniz.')
                                            ->columnSpanFull(),

                                        Forms\Components\Select::make('menu_category_id')
                                            ->label('Kategori')
                                            ->relationship('menuCategory', 'title')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Kategori Adı')
                                                    ->required()
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $state ? $set('slug', Str::slug($state)) : null),

                                                Forms\Components\TextInput::make('slug')
                                                    ->label('Slug')
                                                    ->required(),
                                            ])
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('price')
                                            ->label('Fiyat')
                                            ->prefix('₺')
                                            ->default(0)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('likes')
                                            ->label('Beğeni Sayısı')
                                            ->numeric()
                                            ->default(0)
                                            ->columnSpanFull(),

                                        // --- GÖRSEL YÜKLEME ---
                                        Forms\Components\FileUpload::make('img')
                                            ->label('Ürün Görseli')
                                            ->image()
                                            ->disk('uploads') // Senin sistemindeki disk
                                            ->directory('menus')
                                            ->imageEditor()
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
                                            ->label('Ürün Adı')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                                            ->columnSpanFull(),

                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug (URL)')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->columnSpanFull(),

                                        Forms\Components\RichEditor::make('desc')
                                            ->label('Açıklama / İçindekiler')
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('SEO Ayarları')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')->label('Meta Başlık')->columnSpanFull(),
                                        Forms\Components\Textarea::make('meta_desc')->label('Meta Açıklama')->rows(2)->columnSpanFull(),
                                        Forms\Components\TextInput::make('meta_keywords')->label('Anahtar Kelimeler')->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                // --- 1. XLSX YÜKLEME (IMPORT) ---
                Tables\Actions\Action::make('importExcel')
                    ->label('Excel Yükle (XLSX)')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('primary')
                    ->form([
                        FileUpload::make('file')
                            ->label('Excel Dosyası (.xlsx)')
                            ->disk('uploads')        // Dosyayı uploads diskine kaydet
                            ->directory('menuexcel') // menuexcel klasörü altına
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        // DEĞİŞİKLİK: Storage Facade yerine doğrudan public_path kullanıyoruz.
                        // Dosyanın yolu: public/uploads/menuexcel/dosya.xlsx olacak şekilde ayarlandı.
                        $path = public_path('uploads/' . $data['file']);

                        if (!file_exists($path)) {
                            Notification::make()
                                ->title('Hata')
                                ->body('Dosya bulunamadı. Yol: ' . $path)
                                ->danger()
                                ->send();
                            return;
                        }

                        try {
                            // Import işlemini başlat
                            Excel::import(new MenuImport, $path);

                            Notification::make()
                                ->title('Yükleme Başarılı')
                                ->body('Ürünler başarıyla eklendi.')
                                ->success()
                                ->send();

                            // DEĞİŞİKLİK: Storage::delete yerine saf PHP unlink komutu
                            // İşlem bitince dosyayı siliyoruz.
                            if (file_exists($path)) {
                                unlink($path);
                            }

                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Hata')
                                ->body('Dosya okunurken hata oluştu: ' . $e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    }),

                // --- 2. XLSX İNDİRME (EXPORT) ---
                ExportAction::make()
                    ->exports([
                        ExcelExport::make()
                            ->fromTable() // Tablodaki sütunları otomatik al
                            ->withFilename('Menu-Listesi-' . date('d-m-Y'))
                            ->withColumns([
                                // Ekstra sütun eklemek istersen:
                                Column::make('desc')->heading('Açıklama'),
                            ])
                    ])
                    ->label('Excel İndir (XLSX)')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success'),
            ])
            ->columns([
                Tables\Columns\ImageColumn::make('img')
                    ->label('Görsel')
                    ->disk('uploads')
                    ->circular(),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Ürün Adı')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('menuCategory.title')
                    ->label('Kategori')
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Fiyat')
                    ->money('TRY')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Durum')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('menu_category_id')
                    ->label('Kategoriye Göre Filtrele')
                    ->relationship('menuCategory', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // Toplu Seçimden Excel İndirme
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->withFilename('Secilen-Urunler-' . date('Y-m-d'))
                        ])
                        ->label('Seçilenleri İndir'),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}