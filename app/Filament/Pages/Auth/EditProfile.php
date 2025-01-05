<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
  public function form(Form $form): Form
  {
    return $form
      ->schema([
        $this->getAvatarFormComponent(),
        $this->getNameFormComponent(),
        $this->getEmailFormComponent(),
        $this->getPasswordFormComponent(),
        $this->getPasswordConfirmationFormComponent(),
        $this->getAboutFormComponent(),
      ]);
  }

  public function getAvatarFormComponent(): Forms\Components\FileUpload
  {
    return Forms\Components\FileUpload::make('avatar_url')
      ->translateLabel()
      ->avatar();
  }

  public function getAboutFormComponent(): Forms\Components\Textarea
  {
    return Forms\Components\Textarea::make('about')
      ->translateLabel()
      ->columnSpan('full')
      ->required()
      ->rows(5);
  }
}
