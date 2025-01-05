<?php

namespace App\Filament\Participant\Resources;

use App\Filament\Participant\Resources\ReportResource\Pages;
use App\Models\Report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Joaopaulolndev\FilamentPdfViewer\Infolists as CustomInfolist;
use Filament\Infolists;
use Illuminate\Support\Facades\Auth;

class ReportResource extends Resource
{
  protected static ?string $model = Report::class;

  protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

  public static function getModelLabel(): string
  {
    return __('Reports');
  }

  public static function getNavigationGroup(): ?string
  {
    return __('Learning Management');
  }

  public static function getEloquentQuery(): EloquentBuilder
  {
    $user = Auth::user();
    return parent::getEloquentQuery()->where('participant_id', $user->participant->id);
  }

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\TextInput::make('title')
          ->columnSpan('full')
          ->translateLabel()
          ->required(),

        Forms\Components\Textarea::make('description')
          ->columnSpan('full')
          ->translateLabel()
          ->required()
          ->rows(5),

        Forms\Components\FileUpload::make('file')
          ->acceptedFileTypes(['application/pdf'])
          ->columnSpan('full')
          ->translateLabel()
          ->downloadable()
          ->maxSize(8192)
          ->moveFiles()
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

        Tables\Columns\TextColumn::make('title')
          ->translateLabel()
          ->searchable(),

        Tables\Columns\TextColumn::make('description')
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
            Infolists\Components\ImageEntry::make('participant.user.avatar_url')
              ->label('Avatar url')
              ->translateLabel()
              ->circular()
              ->size(40),

            Infolists\Components\TextEntry::make('participant.user.name')
              ->label('Participant')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('title')
              ->translateLabel(),

            Infolists\Components\TextEntry::make('description')
              ->translateLabel(),
          ])
          ->columns(2),

        Infolists\Components\Section::make('Attachment')
          ->description('Resource attachment information')
          ->collapsible()
          ->schema([
            CustomInfolist\Components\PdfViewerEntry::make('file')
              ->translateLabel()
              ->minHeight('60svh')
          ])
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
      'index' => Pages\ListReports::route('/'),
      'create' => Pages\CreateReport::route('/create'),
      'view' => Pages\ViewReport::route('/{record}'),
      'edit' => Pages\EditReport::route('/{record}/edit'),
    ];
  }
}
