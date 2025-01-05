<?php

namespace App\Filament\Resources\ParticipantResource\RelationManagers;

use App\Filament\Resources\AttendanceResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AttendanceRelationManager extends RelationManager
{
    protected static string $relationship = 'attendance';


    public function form(Form $form): Form
    {
        return AttendanceResource::form($form);
    }

    public function table(Table $table): Table
    {
        return AttendanceResource::table($table);
    }
}
