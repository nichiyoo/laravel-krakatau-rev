<?php

namespace App\Filament\Resources\DivisionResource\RelationManagers;

use App\Filament\Resources\ParticipantResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ParticipantsRelationManager extends RelationManager
{
  protected static string $relationship = 'participants';

  public function form(Form $form): Form
  {
    return ParticipantResource::form($form);
  }

  public function table(Table $table): Table
  {
    return ParticipantResource::table($table);
  }
}
