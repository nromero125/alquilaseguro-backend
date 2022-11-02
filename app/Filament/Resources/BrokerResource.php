<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrokerResource\Pages;
use App\Models\Bank;
use App\Models\Broker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class BrokerResource extends Resource
{
    protected static ?string $model = Broker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastname')
                    ->required()
                    ->maxLength(255),
                Fieldset::make('Account Information')
                    ->relationship('user')
                    ->schema([
                        TextInput::make('email')
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === "create"),
                    ]),
                Select::make('real_estate_id')
                    ->required()
                    ->searchable()
                    ->relationship('realEstate', 'name'),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('identification')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Select::make('bank_name')
                    ->options(Bank::query()->pluck('name', 'name'))
                    ->searchable(),
                TextInput::make('bank_account')
                    ->maxLength(255),
                Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lastname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identification')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('realEstate.name')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
