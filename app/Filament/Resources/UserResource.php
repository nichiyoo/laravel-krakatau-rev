<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class UserResource extends Resource
{
  protected static ?string $model = User::class;
  protected static ?string $navigationIcon = 'heroicon-o-user';
  protected static ?int $navigationSort = 1;

  public static function getModelLabel(): string
  {
    return __('Users');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Users Management');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\FileUpload::make('avatar_url')
          ->columnSpan('full')
          ->translateLabel()
          ->avatar(),

        Forms\Components\TextInput::make('name')
          ->translateLabel()
          ->required(),

        Forms\Components\TextInput::make('email')
          ->translateLabel()
          ->email()
          ->required(),

        Forms\Components\Select::make('role')
          ->translateLabel()
          ->options([
            'Admin' => 'Admin',
            'None' => 'None',
          ])
          ->visibleOn('create')
          ->required(),

        Forms\Components\TextInput::make('password')
          ->translateLabel()
          ->password()
          ->required()
          ->visibleOn('create')
          ->revealable(),

        Forms\Components\Textarea::make('about')
          ->translateLabel()
          ->columnSpan('full')
          ->required()
          ->rows(5),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\ImageColumn::make('avatar_url')
          ->translateLabel()
          ->circular()
          ->size(40),

        Tables\Columns\TextColumn::make('name')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('email')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('role')
          ->translateLabel()
          ->badge(),

        Tables\Columns\TextColumn::make('email_verified_at')
          ->translateLabel()
          ->dateTime()
          ->sortable()
          ->date('F j, Y'),

        Tables\Columns\TextColumn::make('created_at')
          ->translateLabel()
          ->dateTime()
          ->sortable()
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\TextColumn::make('updated_at')
          ->translateLabel()
          ->dateTime()
          ->sortable()
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),
      ])
      ->filters([
        //
      ])
      ->actions([
        Tables\Actions\ActionGroup::make([
          Tables\Actions\ViewAction::make('view')
            ->translateLabel()
            ->icon('heroicon-o-eye'),

          Tables\Actions\EditAction::make('edit')
            ->translateLabel()
            ->icon('heroicon-o-pencil'),

          Tables\Actions\DeleteAction::make('delete')
            ->translateLabel()
            ->color('danger')
            ->icon('heroicon-o-trash'),
        ])
          ->dropdown(true)
          ->color('gray')
      ])
      ->bulkActions([
        Tables\Actions\BulkActionGroup::make([
          Tables\Actions\DeleteBulkAction::make(),
        ]),
      ])
      ->toggleColumnsTriggerAction(
        fn(Tables\Actions\Action $action) => $action->icon('heroicon-o-ellipsis-vertical'),
      );
  }

  public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
  {
    return $infolist
      ->schema([
        Infolists\Components\Section::make('Details')
          ->description('Resource detail information')
          ->schema([
            Infolists\Components\ImageEntry::make('avatar_url')
              ->label('Avatar url')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('email')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('role')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('about')
              ->translateLabel(),
          ])
          ->columns(2)
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListUsers::route('/'),
      'create' => Pages\CreateUser::route('/create'),
      'view' => Pages\ViewUser::route('/{record}'),
      'edit' => Pages\EditUser::route('/{record}/edit'),
    ];
  }
}
