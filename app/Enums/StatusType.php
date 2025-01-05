<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;

enum StatusType: string implements HasColor, HasIcon, HasLabel
{
  case Available = 'Available';
  case Unavailable = 'Unavailable';

  public function getLabel(): ?string
  {
    return match ($this) {
      self::Available => 'Available',
      self::Unavailable => 'Unavailable',
    };
  }

  public function getColor(): string | array | null
  {
    return match ($this) {
      self::Available => 'success',
      self::Unavailable => 'danger',
    };
  }

  public function getIcon(): ?string
  {
    return match ($this) {
      self::Available => 'heroicon-o-check-circle',
      self::Unavailable => 'heroicon-o-x-circle',
    };
  }
}
