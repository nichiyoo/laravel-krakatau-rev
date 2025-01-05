<?php

namespace App\Filament\Resources\ParticipantResource\Pages;

use App\Filament\Resources\ParticipantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateParticipant extends CreateRecord
{
  protected static string $resource = ParticipantResource::class;

  protected function afterCreate(): void
  {
    $participant = $this->record;

    $user = $participant->user;
    $user->role = 'Participant';
    $user->save();
  }
}
