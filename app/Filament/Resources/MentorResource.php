<?php

namespace App\Filament\Resources;

use App\Enums\RoleType;
use App\Filament\Resources\InstitutionResource\RelationManagers\ParticipantsRelationManager;
use App\Filament\Resources\MentorResource\Pages;
use App\Models\Mentor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;

class MentorResource extends Resource
{
  protected static ?string $model = Mentor::class;
  protected static ?string $navigationIcon = 'heroicon-o-users';
  protected static ?int $navigationSort = 3;

  public static function getModelLabel(): string
  {
    return __('Mentors');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Internal Management');
  }

  public static function getNavigationBadge(): ?string
  {
    return static::getModel()::count();
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('user_id')
          ->columnSpan('full')
          ->translateLabel()
          ->relationship(name: 'user', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query) => $query->where('role', RoleType::None),)
          ->searchable(['name', 'email'])
          ->preload()
          ->required()
          ->visibleOn('create')
          ->prefixIcon('heroicon-o-user'),

        Forms\Components\Select::make('division_id')
          ->translateLabel()
          ->relationship(name: 'division', titleAttribute: 'name')
          ->createOptionForm([
            Forms\Components\TextInput::make('name')
              ->columnSpan('full')
              ->translateLabel()
              ->required(),

            Forms\Components\Textarea::make('description')
              ->columnSpan('full')
              ->translateLabel(),

            Forms\Components\TextInput::make('capacity')
              ->translateLabel()
              ->numeric()
              ->default(0)
              ->required(),
          ])
          ->searchable(['name'])
          ->preload()
          ->required()
          ->prefixIcon('heroicon-o-building-office-2'),

        Forms\Components\TextInput::make('phone')
          ->translateLabel()
          ->tel()
          ->mask('+62 999 9999 99999')
          ->prefixIcon('heroicon-o-phone'),
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

        Tables\Columns\ImageColumn::make('user.avatar_url')
          ->translateLabel()
          ->circular()
          ->size(40),

        Tables\Columns\TextColumn::make('user.name')
          ->label('Name')
          ->translateLabel()
          ->searchable()
          ->sortable(),

        Tables\Columns\TextColumn::make('phone')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('status')
          ->translateLabel()
          ->badge(),

        Tables\Columns\TextColumn::make('division.name')
          ->translateLabel()
          ->numeric()
          ->sortable(),
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
            Infolists\Components\ImageEntry::make('user.avatar_url')
              ->label('Avatar url')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('user.name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('phone')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('status')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('division.name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('division.description')
              ->label('Description')
              ->translateLabel()
          ])
          ->columns(2)
      ]);
  }

  public static function getRelations(): array
  {
    return [
      ParticipantsRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListMentors::route('/'),
      'create' => Pages\CreateMentor::route('/create'),
      'view' => Pages\ViewMentor::route('/{record}'),
      'edit' => Pages\EditMentor::route('/{record}/edit'),
    ];
  }
}
