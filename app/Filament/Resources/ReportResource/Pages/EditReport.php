<?php

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
  protected static string $resource = ReportResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make()->translateLabel()->icon('heroicon-o-eye'),
      Actions\DeleteAction::make()->translateLabel()->color('danger')->icon('heroicon-o-trash'),
    ];
  }
}
