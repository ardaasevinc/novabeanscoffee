<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Notifications\Auth\Concerns\HasDatabaseNotifications;
use Illuminate\Notifications\HasDatabaseNotifications as NotificationsHasDatabaseNotifications;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, NotificationsHasDatabaseNotifications;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Filament Admin paneline erişim yetkisi.
     */
  public function canAccessPanel(Panel $panel): bool
{
    /**
     * Erişim Kuralları:
     * 1. E-posta adresi '@novakitchen.com.tr' ile biten tüm kullanıcılar.
     * 2. Özel olarak tanımlanmış yönetici e-posta adresi.
     */
    return str_ends_with($this->email, '@novakitchen.com.tr') || 
           $this->email === 'ardaasevinc@gmail.com';
}
}