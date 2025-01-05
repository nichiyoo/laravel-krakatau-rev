<?php

namespace App\Filament\Participant\Pages;

use App\Enums\RoleType;
use App\Models\User;
use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;

class Accounts extends Page implements HasForms
{
  use InteractsWithForms;

  protected static string $view = 'filament.participant.pages.accounts';
  protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

  public ?array $data = [];

  public function getHeading(): string
  {
    return __('Account Detail');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Settings');
  }


  public function mount(): void
  {
    $data = User::with(
      'participant.institution',
      'participant.mentor.user',
      'participant.mentor.division'
    )->where('id', Auth::user()->id)->first();
    $data = $data->toArray();
    $this->form->fill($data);
  }

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Section::make('Informasi Pengguna')
          ->description('Detail informasi pengguna')
          ->schema([
            Forms\Components\TextInput::make('name')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('email')
              ->translateLabel()
              ->email()
              ->disabled(),

            Forms\Components\Select::make('role')
              ->translateLabel()
              ->options(RoleType::class)
              ->disabled(),

            Forms\Components\Textarea::make('about')
              ->translateLabel()
              ->columnSpan('full')
              ->disabled()
              ->rows(5),
          ])
          ->columns(2)
          ->aside(),

        Forms\Components\Section::make('Informasi Institusi')
          ->description('Detail informasi Institusi')
          ->schema([
            Forms\Components\TextInput::make('participant.institution.name')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('participant.institution.region')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('participant.institution.city')
              ->translateLabel()
              ->disabled(),

            Forms\Components\Textarea::make('participant.institution.description')
              ->translateLabel()
              ->columnSpan('full')
              ->disabled()
              ->rows(5),
          ])
          ->columns(2)
          ->aside(),

        Forms\Components\Section::make('Informasi Mentor')
          ->description('Detail informasi mentor')
          ->schema([
            Forms\Components\TextInput::make('participant.mentor.user.name')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('participant.mentor.user.email')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('participant.mentor.user.role')
              ->translateLabel()
              ->disabled(),

            Forms\Components\TextInput::make('participant.mentor.division.name')
              ->label('Division')
              ->translateLabel()
              ->disabled(),

            Forms\Components\Textarea::make('participant.mentor.division.description')
              ->translateLabel()
              ->columnSpan('full')
              ->disabled()
              ->rows(5),
          ])
          ->columns(2)
          ->aside(),
      ])
      ->statePath('data');
  }
}
