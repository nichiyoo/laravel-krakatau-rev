<?php

namespace App\Filament\Resources\MentorResource\Pages;

use App\Filament\Resources\MentorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMentor extends ViewRecord
{
  protected static string $resource = MentorResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make()->translateLabel()->icon('heroicon-o-pencil')
    ];
  }
}
