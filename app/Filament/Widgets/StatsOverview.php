<?php

namespace App\Filament\Widgets;

use App\Enums\RoleType;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
  protected function getStats(): array
  {
    $total = User::count();
    $mentor = User::where('role', RoleType::Mentor)->count();
    $participant = User::where('role', RoleType::Participant)->count();

    return [
      Stat::make('Jumlah Data Pengguna', $total)
        ->description('Jumlah data pengguna di sistem')
        ->descriptionIcon('heroicon-o-user', \Filament\Support\Enums\IconPosition::Before),

      Stat::make('Jumlah Data Mentor', $mentor)
        ->color('success')
        ->description('Jumlah data mentor di sistem')
        ->descriptionIcon('heroicon-o-user', \Filament\Support\Enums\IconPosition::Before),

      Stat::make('Jumlah Data Partisipan', $participant)
        ->color('warning')
        ->description('Jumlah data partisipan di sistem')
        ->descriptionIcon('heroicon-o-user', \Filament\Support\Enums\IconPosition::Before),
    ];
  }
}
