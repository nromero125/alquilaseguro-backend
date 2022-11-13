<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsurerResource\Pages;
use App\Models\Insurer;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Collection;

class InsurerResource extends Resource
{
    protected static ?string $model = Insurer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make('delete')
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInsurers::route('/'),
            'create' => Pages\CreateInsurer::route('/create'),
            'edit' => Pages\EditInsurer::route('/{record}/edit'),
        ];
    }
}
