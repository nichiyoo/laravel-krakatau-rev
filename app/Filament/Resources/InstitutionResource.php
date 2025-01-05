<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstitutionResource\Pages;
use App\Filament\Resources\InstitutionResource\RelationManagers\ParticipantsRelationManager;
use App\Models\Institution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;

class InstitutionResource extends Resource
{
  protected static ?string $model = Institution::class;
  protected static ?string $navigationIcon = 'heroicon-o-building-library';
  protected static ?int $navigationSort = 1;

  public static function getModelLabel(): string
  {
    return __('Institutions');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('External Management');
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
          ->columnSpan('full')
          ->translateLabel()
          ->required()
          ->rows(5),

        Forms\Components\TextInput::make('region')
          ->translateLabel()
          ->required()
          ->prefixIcon('heroicon-o-map-pin'),

        Forms\Components\TextInput::make('city')
          ->translateLabel()
          ->required()
          ->prefixIcon('heroicon-o-map-pin'),
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

        Tables\Columns\ImageColumn::make('participants.user.avatar_url')
          ->label('Pariticipant')
          ->translateLabel()
          ->circular()
          ->stacked()
          ->limit(2)
          ->limitedRemainingText(isSeparate: true),

        Tables\Columns\TextColumn::make('region')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('city')
          ->translateLabel()
          ->searchable(),
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

            Infolists\Components\TextEntry::make('description')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('region')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('city')
              ->translateLabel(),

            Infolists\Components\ImageEntry::make('participants.user.avatar_url')
              ->label('Participant')
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
      ParticipantsRelationManager::class
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListInstitutions::route('/'),
      'create' => Pages\CreateInstitution::route('/create'),
      'view' => Pages\ViewInstitution::route('/{record}'),
      'edit' => Pages\EditInstitution::route('/{record}/edit'),
    ];
  }
}
