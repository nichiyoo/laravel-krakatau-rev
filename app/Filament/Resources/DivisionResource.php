<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DivisionResource\Pages;
use App\Filament\Resources\DivisionResource\RelationManagers\MentorsRelationManager;
use App\Filament\Resources\DivisionResource\RelationManagers\ParticipantsRelationManager;
use App\Filament\Resources\DivisionResource\Widgets\DivisionChart;
use App\Models\Division;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class DivisionResource extends Resource
{
  protected static ?string $model = Division::class;
  protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
  protected static ?int $navigationSort = 1;

  public static function getModelLabel(): string
  {
    return __('Divisions');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Internal Management');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('name')
          ->columnSpan('full')
          ->translateLabel()
          ->required(),

        Forms\Components\Textarea::make('description')
          ->translateLabel()
          ->columnSpan('full')
          ->required()
          ->rows(5),

        Forms\Components\TextInput::make('capacity')
          ->translateLabel()
          ->numeric()
          ->default(0)
          ->required(),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
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

        Tables\Columns\TextColumn::make('name')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\ImageColumn::make('mentors.user.avatar_url')
          ->label('Mentor')
          ->translateLabel()
          ->circular()
          ->stacked()
          ->limit(2)
          ->limitedRemainingText(isSeparate: true),

        Tables\Columns\TextColumn::make('capacity')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('filled')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('status')
          ->translateLabel()
          ->badge(),
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
      )
      ->recordAction(Tables\Actions\ViewAction::class);
  }

  public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
  {
    return $infolist
      ->schema([
        Infolists\Components\Section::make('Details')
          ->description('Resource detail information')
          ->schema([
            Infolists\Components\TextEntry::make('name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('capacity')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('status')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('description')
              ->translateLabel(),

            Infolists\Components\ImageEntry::make('mentors.user.avatar_url')
              ->label('Mentor')
              ->translateLabel()
              ->circular()
              ->stacked()
              ->limit(2)
              ->limitedRemainingText(isSeparate: true),
          ])
          ->columns(2)
      ]);
  }

  public static function getRelations(): array
  {
    return [
      MentorsRelationManager::class,
      ParticipantsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListDivisions::route('/'),
      'create' => Pages\CreateDivision::route('/create'),
      'view' => Pages\ViewDivision::route('/{record}'),
      'edit' => Pages\EditDivision::route('/{record}/edit'),
    ];
  }
}
