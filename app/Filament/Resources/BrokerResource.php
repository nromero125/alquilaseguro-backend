<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrokerResource\Pages;
use App\Models\Broker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Collection;

class BrokerResource extends Resource
{
    protected static ?string $model = Broker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('real_estate_id')
                    ->required()
                    ->searchable()
                    ->relationship('realEstate', 'name'),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('firstname')
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastname')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->bulkActions([
                DeleteBulkAction::make('delete')
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->requiresConfirmation(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrokers::route('/'),
            'create' => Pages\CreateBroker::route('/create'),
            'edit' => Pages\EditBroker::route('/{record}/edit'),
        ];
    }
}
