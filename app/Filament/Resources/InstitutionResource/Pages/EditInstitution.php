<?php

namespace App\Filament\Resources\InstitutionResource\Pages;

use App\Filament\Resources\InstitutionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInstitution extends EditRecord
{
  protected static string $resource = InstitutionResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make()->translateLabel()->icon('heroicon-o-eye'),
      Actions\DeleteAction::make()->translateLabel()->color('danger')->icon('heroicon-o-trash'),
    ];
  }
}
