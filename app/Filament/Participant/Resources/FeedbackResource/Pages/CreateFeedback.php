<?php

namespace App\Filament\Participant\Resources\FeedbackResource\Pages;

use App\Filament\Participant\Resources\FeedbackResource;
use App\Models\Feedback;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateFeedback extends CreateRecord
{
  protected static string $resource = FeedbackResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['participant_id'] = Auth::user()->participant->id;
    return $data;
  }

  protected function beforeCreate(): void
  {
    $feedback = Feedback::where('participant_id', Auth::user()->participant->id)
      ->first();

    if (!$feedback) return;

    Notification::make()
      ->warning()
      ->title('Umpan Balik sudah ada')
      ->body('Umpan balik untuk mentor dan partisipan ini sudah ada')
      ->icon('heroicon-o-exclamation-circle')
      ->send();

    $this->halt();
  }
}
