<?php

namespace App\Filament\Participant\Resources\FeedbackResource\Pages;

use App\Filament\Participant\Resources\FeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFeedback extends ViewRecord
{
  protected static string $resource = FeedbackResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make()->translateLabel()->icon('heroicon-o-pencil'),
    ];
  }
}
