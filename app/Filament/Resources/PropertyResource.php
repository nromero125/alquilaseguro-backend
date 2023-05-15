<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
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

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.property', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(trans('messages.name'))
                    ->required()
                    ->maxLength(255),
                Select::make('owner_id')
                    ->label(trans('messages.owner'))
                    ->required()
                    ->searchable()
                    ->relationship('owner', 'fullname')
                    ->preload(),
                Select::make('broker_id')
                    ->required()
                    ->searchable()
                    ->relationship('broker', 'fullname')
                    ->preload(),
                Select::make('tenant_id')
                    ->label(trans_choice('messages.tenant', 1))
                    ->searchable()
                    ->relationship('tenant', 'fullname')
                    ->preload(),
                Select::make('real_estate_id')
                    ->label(trans_choice('messages.realEstate', 1))
                    ->required()
                    ->searchable()
                    ->relationship('realState', 'name')
                    ->preload(),
                DatePicker::make('payment_due_date')
                    ->label(trans('messages.paymentDueDate'))
                    ->placeholder(trans('messages.paymentDueDate'))
                    ->required(),
                TextInput::make('monthly_payment')
                    ->label(trans('messages.monthlyPayment'))
                    ->placeholder('0.00')
                    ->required()
                    ->numeric(),
                TextInput::make('code')
                    ->label(trans('messages.code'))
                    ->placeholder(trans('messages.code'))
                    ->required()
                    ->maxLength(20),
                Textarea::make('description')
                    ->placeholder(trans('messages.description'))
                    ->label(trans('messages.description')),
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
                TextColumn::make('name')
                    ->label(trans('messages.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('code')
                    ->label(trans('messages.code'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('owner.firstname')
                    ->label(trans('messages.firstName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tenant.lastname')
                    ->label(trans('messages.lastName'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('monthly_payment')
                    ->label(trans('messages.monthlyPayment'))
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
