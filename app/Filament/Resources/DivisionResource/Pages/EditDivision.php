<?php

namespace App\Filament\Resources\DivisionResource\Pages;

use App\Filament\Resources\DivisionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDivision extends EditRecord
{
  protected static string $resource = DivisionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make()->translateLabel()->icon('heroicon-o-eye'),
      Actions\DeleteAction::make()->translateLabel()->color('danger')->icon('heroicon-o-trash'),
    ];
  }
}
