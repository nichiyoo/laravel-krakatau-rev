<?php

namespace App\Filament\Participant\Resources\FeedbackResource\Pages;

use App\Filament\Participant\Resources\FeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditFeedback extends EditRecord
{
  protected static string $resource = FeedbackResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\ViewAction::make()->translateLabel()->icon('heroicon-o-eye'),
      Actions\DeleteAction::make()->translateLabel()->color('danger')->icon('heroicon-o-trash'),
    ];
  }

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['mentor_id'] = Auth::user()->participant->mentor->id;
    $data['participant_id'] = Auth::user()->participant->id;
    return $data;
  }
}
