<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum AttendanceType: string implements HasColor, HasIcon, HasLabel
{
  case Ongoing = 'Ongoing';
  case Completed = 'Completed';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::Ongoing => 'Ongoing',
      self::Completed => 'Completed',
    };
  }

  public function getColor(): string | array | null
  {
    return match ($this) {
      self::Ongoing => 'success',
      self::Completed => 'danger',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::Ongoing => 'heroicon-o-check-circle',
      self::Completed => 'heroicon-o-x-circle',
    };
  }
}
