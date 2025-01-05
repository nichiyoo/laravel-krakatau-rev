<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
  protected static string $resource = UserResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make()->translateLabel()->icon('heroicon-o-eye'),
      Actions\DeleteAction::make()->translateLabel()->color('danger')->icon('heroicon-o-trash'),
    ];
  }
}
