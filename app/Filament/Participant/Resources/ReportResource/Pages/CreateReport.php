<?php

namespace App\Filament\Participant\Resources\ReportResource\Pages;

use App\Filament\Participant\Resources\ReportResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReport extends CreateRecord
{
  protected static string $resource = ReportResource::class;

  protected function mutateFormDataBeforeCreate(array $data): array
  {
    $data['participant_id'] = Auth::user()->participant->id;
    return $data;
  }
}
