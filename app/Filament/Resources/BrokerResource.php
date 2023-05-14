<?php

namespace App\Filament\Resources;

use App\Enums\IdentificationTypes;
use App\Filament\Resources\BrokerResource\Pages;
use App\Models\Bank;
use App\Models\Broker;
use App\Util\Util;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Closure;

class BrokerResource extends Resource
{
    protected static ?string $model = Broker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        $idTypes = array_map(
            fn ($item) => trans("identificationTypes.$item"),
            array_flip(IdentificationTypes::options())
        );

        return $form
            ->schema([
                TextInput::make('firstname')
                    ->label(trans('messages.firstName'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder(trans('messages.firstName')),
                TextInput::make('lastname')
                    ->label(trans('messages.lastName'))
                    ->required()
                    ->maxLength(255)
                    ->placeholder(trans('messages.lastName')),
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->placeholder('Email'),
                TextInput::make('password')
                    ->label(trans('messages.password'))
                    ->placeholder(trans('messages.password'))
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('real_estate_id')
                    ->label(trans_choice('messages.realEstate', 1))
                    ->required()
                    ->searchable()
                    ->relationship('realEstate', 'name')
                    ->preload(),
                TextInput::make('phone_number')
                    ->placeholder(trans('messages.phoneNumber'))
                    ->label(trans('messages.phoneNumber'))
                    ->tel()
                    ->numeric(),
                Select::make('identification_type')
                    ->label(trans('messages.identiticationType'))
                    ->options($idTypes)
                    ->required()
                    ->reactive(),
                TextInput::make('identification')
                    ->label(trans('messages.identification'))
                    ->placeholder(trans('messages.identification'))
                    ->required()
                    ->rules([
                        function (Closure $get) {
                            return function (string $attribute, $value, Closure $fail) use ($get) {
                                if ($get('identification_type') === IdentificationTypes::DOMINICAN_ID->value && !Util::isValid($value)) {
                                    $fail(trans('validation.regex', ['attribute' => trans('messages.identification')]));
                                }
                            };
                        }
                    ])
                    ->numeric(fn (Closure $get): bool => $get('identification_type') === IdentificationTypes::DOMINICAN_ID->value)
                    ->maxLength(function (Closure $get): int {
                        return $get('identification_type') === IdentificationTypes::DOMINICAN_ID->value ? 11 : 255;
                    }),
                TextInput::make('address')
                    ->placeholder(trans('messages.address'))
                    ->label(trans('messages.address'))
                    ->required()
                    ->maxLength(255),
                Select::make('bank_name')
                    ->label(trans('messages.bankName'))
                    ->options(Bank::query()->pluck('name', 'name'))
                    ->searchable(),
                TextInput::make('bank_account')
                    ->placeholder(trans('messages.bankAccount'))
                    ->label(trans('messages.bankAccount'))
                    ->maxLength(255),
                Toggle::make('status')
                    ->label(trans('messages.status'))
                    ->required()
                    ->default(true)
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('firstname')
                    ->label(trans('messages.firstName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('lastname')
                    ->label(trans('messages.lastName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label(trans('messages.user'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identification')
                    ->label(trans('messages.identification'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('realEstate.name')
                    ->label(trans_choice('messages.realEstate', 1))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('status')
                    ->label(trans('messages.status'))
                    ->boolean()
                    ->falseColor('danger')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->trueIcon('heroicon-o-check-circle'),
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
