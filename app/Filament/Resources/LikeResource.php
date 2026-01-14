<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LikeResource\Pages;
use App\Models\Like;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LikeResource extends Resource
{
    protected static ?string $model = Like::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Site Beğenileri';
    protected static ?string $modelLabel = 'Beğeni ve Yorum';
    protected static ?string $pluralModelLabel = 'Beğeniler ve Yorumlar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Kullanıcı Bilgileri')
                    ->schema([
                        Forms\Components\TextInput::make('user_name')
                            ->label('Kullanıcı Adı')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Adresi')
                            ->disabled() // IP adresi manuel değiştirilmemeli
                            ->dehydrated(false),
                    ])->columns(2),

                Forms\Components\Section::make('Yorum İçeriği')
                    ->schema([
                        Forms\Components\Toggle::make('is_liked')
                            ->label('Beğendi mi?')
                            ->onIcon('heroicon-m-hand-thumb-up')
                            ->offIcon('heroicon-m-hand-thumb-down')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),
                        Forms\Components\Textarea::make('user_comment')
                            ->label('Kullanıcı Yorumu')
                            ->rows(5)
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Web Sitesinde Yayınla')
                            ->helperText('Bu seçenek aktif olduğunda yorum web sitesinde görünür.')
                            ->default(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_liked')
                    ->label('Durum')
                    ->boolean()
                    ->trueIcon('heroicon-o-hand-thumb-up')
                    ->falseIcon('heroicon-o-hand-thumb-down')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_name')
                    ->label('Kullanıcı')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user_comment')
                    ->label('Yorum')
                    ->limit(50)
                    ->tooltip(fn (Like $record): string => $record->user_comment ?? ''),

                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('Yayında mı?')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Gönderim Tarihi')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Yayın Durumu')
                    ->placeholder('Hepsi')
                    ->trueLabel('Yayındakiler')
                    ->falseLabel('Bekleyenler'),
                
                Tables\Filters\TernaryFilter::make('is_liked')
                    ->label('Beğeni Durumu')
                    ->placeholder('Hepsi')
                    ->trueLabel('Beğenenler')
                    ->falseLabel('Beğenmeyenler'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLikes::route('/'),
            'create' => Pages\CreateLike::route('/create'),
            'edit' => Pages\EditLike::route('/{record}/edit'),
        ];
    }
}