<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsurerResource\Pages;
use App\Models\Insurer;
use App\Models\User;
use App\Util\Util;
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
use App\Enums\IdentificationTypes;

class InsurerResource extends Resource
{
    protected static ?string $model = Insurer::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.insurer', 2);
    }

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
                    ->placeholder(trans('messages.firstName'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('lastname')
                    ->label(trans('messages.lastName'))
                    ->placeholder(trans('messages.lastName'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->placeholder("Email")
                    ->required()
                    ->email()
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
                    ]),
                TextInput::make('password')
                    ->label(trans('messages.password'))
                    ->placeholder(trans('messages.password'))
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('insurance_id')
                    ->label(trans_choice('messages.insurance', 1))
                    ->required()
                    ->searchable()
                    ->relationship('insurance', 'name')
                    ->preload(),
                TextInput::make('phone_number')
                    ->placeholder(trans('messages.phoneNumber'))
                    ->label(trans('messages.phoneNumber'))
                    ->tel()
                    ->mask(fn (TextInput\Mask $mask): TextInput\Mask => $mask->pattern('000-000-0000')),
                Select::make('identification_type')
                    ->label(trans('messages.identificationType'))
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
                Toggle::make('status')
                    ->label(trans('messages.status'))
                    ->required()
                    ->default(true)
                    ->hiddenOn('create'),
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
                TextColumn::make('insurance.name')
                    ->label(trans_choice('messages.insurer', 1))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('status')
                    ->label(trans('messages.status'))
                    ->boolean()
                    ->falseColor('danger')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->trueIcon('heroicon-o-check-circle'),
            ])->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListInsurers::route('/'),
            'create' => Pages\CreateInsurer::route('/create'),
            'edit' => Pages\EditInsurer::route('/{record}/edit'),
        ];
    }
}
