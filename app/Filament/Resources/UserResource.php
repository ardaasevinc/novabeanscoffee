<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash; // Şifreleme için gerekli

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users'; // İkonu kullanıcılara uygun değiştirdim
    
    protected static ?string $navigationLabel = 'Kullanıcılar'; // Sol menüdeki isim
    
    protected static ?string $modelLabel = 'Kullanıcı';

    protected static ?string $pluralModelLabel = 'Kullanıcı İşlemleri';
        protected static ?string $label = 'Kullanıcı';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Ad Soyad')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('email')
                    ->label('E-posta Adresi')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    // Düzenleme yaparken kendi mailine takılmasın:
                    ->unique(ignoreRecord: true), 

                Forms\Components\DateTimePicker::make('email_verified_at')
                    ->label('E-posta Onay Tarihi'),

                Forms\Components\TextInput::make('password')
                    ->label('Şifre')
                    ->password()
                    ->revealable() // Şifreyi göster/gizle butonu
                    // Şifre girildiyse Hashle, girilmediyse null bırakma:
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    // Sadece doluysa veritabanını güncelle (Boşsa eski şifre kalır):
                    ->dehydrated(fn ($state) => filled($state))
                    // Sadece yeni oluştururken zorunlu olsun:
                    ->required(fn (string $operation): bool => $operation === 'create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad Soyad')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable()
                    ->copyable(), // Tıklayınca kopyalar

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label('Onay Durumu')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kayıt Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Silme butonu eklendi
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}