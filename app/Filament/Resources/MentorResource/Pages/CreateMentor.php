<?php

namespace App\Filament\Resources\MentorResource\Pages;

use App\Filament\Resources\MentorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMentor extends CreateRecord
{
  protected static string $resource = MentorResource::class;

  protected function afterCreate(): void
  {
    $mentor = $this->record;

    $user = $mentor->user;
    $user->role = 'Mentor';
    $user->save();
  }
}
