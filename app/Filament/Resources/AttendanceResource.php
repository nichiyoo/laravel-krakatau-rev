<?php

namespace App\Filament\Resources;

use App\Enums\AttendanceType;
use App\Enums\RoleType;
use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;

class AttendanceResource extends Resource
{
  protected static ?string $model = Attendance::class;
  protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
  protected static ?int $navigationSort = 3;

  public static function getModelLabel(): string
  {
    return __('Attendances');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('External Management');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\DatePicker::make('start')
          ->translateLabel()
          ->date('F j, Y')
          ->native(false)
          ->required()
          ->prefixIcon('heroicon-o-calendar-days'),

        Forms\Components\DatePicker::make('end')
          ->translateLabel()
          ->date('F j, Y')
          ->native(false)
          ->required()
          ->prefixIcon('heroicon-o-calendar-days'),

        Forms\Components\ToggleButtons::make('status')
          ->translateLabel()
          ->columnSpan('full')
          ->options(AttendanceType::class)
          ->inline()
          ->required(),

        Forms\Components\TextInput::make('hours')
          ->translateLabel()
          ->required()
          ->numeric()
          ->default(0),

        Forms\Components\TextInput::make('days')
          ->translateLabel()
          ->required()
          ->numeric()
          ->default(0),

        Forms\Components\TextInput::make('presences')
          ->translateLabel()
          ->required()
          ->numeric()
          ->default(0),

        Forms\Components\Select::make('participant_id')
          ->columnSpan('full')
          ->relationship(name: 'participant', titleAttribute: 'id', modifyQueryUsing: fn(Builder $query) => $query->noAttendance(),)
          ->getOptionLabelFromRecordUsing(fn(Participant $record) => $record->user->name)
          ->required()
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
          ->sortable()
          ->date('F j, Y')
          ->toggleable(isToggledHiddenByDefault: true),

        Tables\Columns\ImageColumn::make('participant.user.avatar_url')
          ->label('Avatar url')
          ->translateLabel()
          ->circular()
          ->size(40),

        Tables\Columns\TextColumn::make('participant.user.name')
          ->label('Name')
          ->translateLabel()
          ->searchable()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('start')
          ->translateLabel()
          ->date()
          ->sortable(),

        Tables\Columns\TextColumn::make('end')
          ->translateLabel()
          ->date()
          ->sortable(),

        Tables\Columns\TextColumn::make('status')
          ->translateLabel()
          ->badge(),

        Tables\Columns\TextColumn::make('hours')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('days')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('presences')
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
      );
  }

  public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
  {
    return $infolist
      ->schema([
        Infolists\Components\Section::make('Details')
          ->description('Resource detail information')
          ->schema([
            Infolists\Components\ImageEntry::make('participant.user.avatar_url')
              ->label('Avatar url')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('participant.user.name')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('start')->date('F j, Y')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('end')->date('F j, Y')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('status')
              ->translateLabel()
              ->badge(),
          ])
          ->columns(2)
          ->aside(),

        Infolists\Components\Section::make('Details')
          ->description('Resource detail information')
          ->schema([
            Infolists\Components\TextEntry::make('hours')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('days')
              ->translateLabel()
              ->badge(),

            Infolists\Components\TextEntry::make('presences')
              ->translateLabel()
              ->badge(),
          ])
          ->columns(3)
          ->aside(),
      ]);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => Pages\ListAttendances::route('/'),
      'create' => Pages\CreateAttendance::route('/create'),
      'view' => Pages\ViewAttendance::route('/{record}'),
      'edit' => Pages\EditAttendance::route('/{record}/edit'),
    ];
  }
}
