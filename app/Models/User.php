<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var list<string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'avatar_url',
    'role'
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
      'role' => RoleType::class,
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  /**
   * Determine whether the user can access the given panel.
   *
   * @param  \Filament\Panel  $panel
   * @return bool
   */
  public function canAccessPanel(Panel $panel): bool
  {
    $role = strtolower($this->role->value);
    return $role == $panel->getId();
  }

  /**
   * Get the URL for the avatar of the user.
   *
   * @return string|null
   */
  public function getFilamentAvatarUrl(): ?string
  {
    if (filter_var($this->avatar_url, FILTER_VALIDATE_URL)) return $this->avatar_url;
    return asset($this->avatar_url);
  }


  /**
   * Return the relationship to the mentors of the user.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function mentor(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->hasOne(Mentor::class);
  }

  /**
   * Return the relationship to the participants of the user.
   *
   * @return \Illuminate\Database\Eloquent\Relations\HasOne
   */
  public function participant(): \Illuminate\Database\Eloquent\Relations\HasOne
  {
    return $this->hasOne(Participant::class);
  }
}
