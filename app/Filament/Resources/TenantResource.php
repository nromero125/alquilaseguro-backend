<?php

namespace App\Filament\Resources;

use App\Enums\IdentificationTypes;
use App\Filament\Resources\TenantResource\Pages;
use App\Models\Bank;
use App\Models\Tenant;
use App\Util\Util;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
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

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.tenant', 2);
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
                    ->placeholder('Email')
                    ->required()
                    ->email(),
                TextInput::make('password')
                    ->placeholder(trans('messages.password'))
                    ->label(trans('messages.password'))
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
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
                TextInput::make('address')
                    ->placeholder(trans('messages.address'))
                    ->label(trans('messages.address'))
                    ->required()
                    ->maxLength(255),
                Select::make('bank_name')
                    ->placeholder(trans('messages.bankName'))
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
                SpatieMediaLibraryFileUpload::make('documents')
                    ->label(trans('messages.documents'))
                    ->collection('documents')
                    ->multiple()
                    ->conversionsDisk('s3'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname')
                    ->label(trans('messages.firstName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('identification')
                    ->label(trans('messages.identification'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label(trans('messages.user'))
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
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }
}
