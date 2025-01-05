<?php

namespace App\Filament\Participant\Resources\ReportResource\Pages;

use App\Filament\Participant\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
  protected static string $resource = ReportResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make()->translateLabel()->icon('heroicon-o-pencil'),
    ];
  }
}
