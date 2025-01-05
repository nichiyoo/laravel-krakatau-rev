<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
    Model::unguard();
    Filament::serving(function () {
      Filament::registerNavigationItems([
        NavigationItem::make('Profile')
          ->url('/admin/profile')
          ->icon('heroicon-o-user')
          ->activeIcon('heroicon-o-user')
          ->group('Settings')
      ]);
    });
  }
}
