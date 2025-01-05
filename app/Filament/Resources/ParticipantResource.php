<?php

namespace App\Filament\Resources;

use App\Enums\RoleType;
use App\Enums\StatusType;
use App\Filament\Resources\ParticipantResource\Pages;
use App\Filament\Resources\ParticipantResource\RelationManagers\AttendanceRelationManager;
use App\Models\Mentor;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Illuminate\Support\Facades\DB;

class ParticipantResource extends Resource
{
  protected static ?string $model = Participant::class;
  protected static ?string $navigationIcon = 'heroicon-o-user';
  protected static ?int $navigationSort = 2;

  public static function getModelLabel(): string
  {
    return __('Participants');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('External Management');
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
          ->translateLabel()
          ->relationship(name: 'user', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query) => $query->where('role', RoleType::None))
          ->searchable(['name', 'email'])
          ->preload()
          ->required()
          ->visibleOn('create')
          ->prefixIcon('heroicon-o-user'),

        Forms\Components\TextInput::make('phone')
          ->translateLabel()
          ->tel()
          ->mask('+62 999 9999 99999')
          ->prefixIcon('heroicon-o-phone'),

        Forms\Components\Select::make('institution_id')
          ->translateLabel()
          ->relationship('institution', 'name')
          ->createOptionForm([
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
          ])
          ->searchable(['name'])
          ->preload()
          ->required()
          ->prefixIcon('heroicon-o-building-library'),

        Forms\Components\TextInput::make('position')
          ->translateLabel()
          ->required(),

        Forms\Components\Select::make('mentor_id')
          ->columnSpan('full')
          ->relationship(name: 'mentor', titleAttribute: 'id', modifyQueryUsing: fn(Builder $query) => $query->available())
          ->getOptionLabelFromRecordUsing(fn(Mentor $record) => $record->user->name)
          ->searchable(['name'])
          ->preload()
          ->required()
          ->prefixIcon('heroicon-o-user'),
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
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\ImageColumn::make('user.avatar_url')
          ->label('Avatar url')
          ->translateLabel()
          ->circular()
          ->size(40),

        Tables\Columns\TextColumn::make('user.name')
          ->label('Name')
          ->translateLabel()
          ->searchable()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('phone')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('position')
          ->translateLabel()
          ->badge(),

        Tables\Columns\TextColumn::make('mentor.user.name')
          ->label('Mentor')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('institution.name')
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

            Infolists\Components\TextEntry::make('position')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('institution.name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('institution.description')
              ->label('Description')
              ->translateLabel(),
          ])
          ->columns(2)
      ]);
  }

  public static function getRelations(): array
  {
    return [
      AttendanceRelationManager::class,
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListParticipants::route('/'),
      'create' => Pages\CreateParticipant::route('/create'),
      'view' => Pages\ViewParticipant::route('/{record}'),
      'edit' => Pages\EditParticipant::route('/{record}/edit'),
    ];
  }
}
