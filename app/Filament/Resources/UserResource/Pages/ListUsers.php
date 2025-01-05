<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
  protected static string $resource = UserResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\CreateAction::make()->translateLabel()->icon('heroicon-o-plus'),
    ];
  }

  public function getTabs(): array
  {
    return [
      'all' => Tab::make('All'),
      'admin' => Tab::make('Admin')->query(fn(Builder $query) => $query->where('role', 'Admin')),
      'mentor' => Tab::make('Mentor')->query(fn(Builder $query) => $query->where('role', 'Mentor')),
      'participant' => Tab::make('Participant')->query(fn(Builder $query) => $query->where('role', 'Participant')),
      'none' => Tab::make('None')->query(fn(Builder $query) => $query->where('role', 'None')),
    ];
  }
}
