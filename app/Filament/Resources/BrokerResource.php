<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrokerResource\Pages;
use App\Models\Bank;
use App\Models\Broker;
use App\Models\User;
use Closure;
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

class BrokerResource extends Resource
{
    protected static ?string $model = Broker::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.broker', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('firstname')
                    ->label(trans('messages.firstName'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastname')
                    ->label(trans('messages.lastName'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->rules([
                        function (Closure $get) {
                            $userId = $get('user_id');

                            return function (string $attribute, $value, Closure $fail) use ($userId) {
                                $emails = User::query()
                                    ->select('email')
                                    ->whereNot('id', $userId)
                                    ->pluck('email')
                                    ->toArray();

                                if (in_array($value, $emails)) {
                                    $fail(trans('validation.unique'));
                                }
                            };
                        },
                    ])
                    ->email(),
                TextInput::make('password')
                    ->label(trans('messages.password'))
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('real_estate_id')
                    ->label(trans_choice('messages.realEstate', 1))
                    ->required()
                    ->searchable()
                    ->relationship('realEstate', 'name'),
                TextInput::make('phone_number')
                    ->label(trans('messages.phoneNumber'))
                    ->tel(),
                TextInput::make('identification')
                    ->label(trans('messages.identification'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->label(trans('messages.address'))
                    ->required()
                    ->maxLength(255),
                Select::make('bank_name')
                    ->label(trans('messages.bankName'))
                    ->options(Bank::query()->pluck('name', 'name'))
                    ->searchable(),
                TextInput::make('bank_account')
                    ->label(trans('messages.bankAccount'))
                    ->maxLength(255),
                Toggle::make('status')
                    ->label(trans('messages.status'))
                    ->default(true),
                Toggle::make('is_admin')
                    ->label(trans('messages.isAdmin'))
                    ->default(false),
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
                    ->label(trans_choice('messages.user', 1))
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
