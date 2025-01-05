<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use App\Models\Mentor;
use App\Models\Participant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Mokhosh\FilamentRating;

class FeedbackResource extends Resource
{
  protected static ?string $model = Feedback::class;

  protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left';

  public static function getModelLabel(): string
  {
    return __('Feedbacks');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Learning Management');
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Textarea::make('feedback')
          ->columnSpan('full')
          ->translateLabel()
          ->required()
          ->rows(5),

        FilamentRating\Components\Rating::make('score')
          ->columnSpan('full')
          ->color('warning')
          ->stars(5)
          ->required(),

        Forms\Components\Select::make('participant_id')
          ->columnSpan('full')
          ->relationship(name: 'participant', titleAttribute: 'id', modifyQueryUsing: fn(Builder $query) => $query->noFeedback(),)
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

        Tables\Columns\TextColumn::make('participant.mentor.user.name')
          ->label('Mentor')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        Tables\Columns\TextColumn::make('participant.user.name')
          ->label('Participant')
          ->translateLabel()
          ->numeric()
          ->sortable(),

        FilamentRating\Columns\RatingColumn::make('score')
          ->translateLabel()
          ->color('warning')
          ->stars(5)
          ->sortable(),

        Tables\Columns\TextColumn::make('feedback')
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
      );
  }

  public static function infolist(Infolists\Infolist $infolist): Infolists\Infolist
  {
    return $infolist
      ->schema([
        Infolists\Components\Section::make('Details')
          ->description('Resource detail information')
          ->schema([
            Infolists\Components\ImageEntry::make('mentor.user.avatar_url')
              ->label('Mentor Avatar')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('mentor.user.name')
              ->label('Mentor')
              ->translateLabel(),

            Infolists\Components\ImageEntry::make('participant.user.avatar_url')
              ->label('Participant Avatar')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('participant.user.name')
              ->label('Participant')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('feedback')
              ->translateLabel(),

            FilamentRating\Entries\RatingEntry::make('score')
              ->translateLabel()
              ->color('warning')
              ->stars(5),
          ])
          ->columns(2)
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
      'index' => Pages\ListFeedback::route('/'),
      'create' => Pages\CreateFeedback::route('/create'),
      'view' => Pages\ViewFeedback::route('/{record}'),
      'edit' => Pages\EditFeedback::route('/{record}/edit'),
    ];
  }
}
