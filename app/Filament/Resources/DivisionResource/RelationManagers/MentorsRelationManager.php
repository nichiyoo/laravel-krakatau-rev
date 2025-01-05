<?php

namespace App\Filament\Resources\DivisionResource\RelationManagers;

use App\Filament\Resources\MentorResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class MentorsRelationManager extends RelationManager
{
  protected static string $relationship = 'mentors';

  public function form(Form $form): Form
  {
    return MentorResource::form($form);
  }

  public function table(Table $table): Table
  {
    return MentorResource::table($table);
  }
}
