<?php

namespace App\Filament\Participant\Resources\ReportResource\Pages;

use App\Filament\Participant\Resources\ReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

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

  protected function mutateFormDataBeforeSave(array $data): array
  {
    $data['participant_id'] = Auth::user()->participant->id;
    return $data;
  }
}
