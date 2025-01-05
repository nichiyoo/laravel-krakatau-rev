<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum RoleType: string implements HasColor, HasIcon, HasLabel
{
  case Admin = 'Admin';
  case Mentor = 'Mentor';
  case Participant = 'Participant';
  case None = 'None';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::Admin => 'Admin',
      self::Mentor => 'Mentor',
      self::Participant => 'Participant',
      self::None => 'None',
    };
  }

  public function getColor(): string | array | null
  {
    return match ($this) {
      self::Admin => 'success',
      self::Mentor => 'primary',
      self::Participant => 'warning',
      self::None => 'gray',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::Admin => 'heroicon-o-shield-check',
      self::Mentor => 'heroicon-o-user-group',
      self::Participant => 'heroicon-o-user',
      self::None => null,
    };
  }
}
