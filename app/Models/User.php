<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'operator'], true);
    }

    /**
     * Check whether this user is the last administrator.
     */
    public function isLastAdmin(): bool
    {
        return $this->role === 'admin'
            && ! self::query()
                ->where('role', 'admin')
                ->whereKeyNot($this->getKey())
                ->exists();
    }

    /**
     * Check whether another administrator exists.
     */
    public function hasOtherAdmin(): bool
    {
        return self::query()
            ->where('role', 'admin')
            ->whereKeyNot($this->getKey())
            ->exists();
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
