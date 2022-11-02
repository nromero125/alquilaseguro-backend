<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                Select::make('owner_id')
                    ->required()
                    ->searchable()
                    ->relationship('owner', 'firstname'),
                Select::make('broker_id')
                    ->required()
                    ->searchable()
                    ->relationship('broker', 'firstname'),
                Select::make('tenant_id')
                    ->required()
                    ->searchable()
                    ->relationship('tenant', 'firstname'),
                Select::make('real_estate_id')
                    ->required()
                    ->searchable()
                    ->relationship('realState', 'name'),
                DatePicker::make('payment_due_date')->required(),
                TextInput::make('monthly_payment')->required()->numeric(),
                TextInput::make('code')->required()->maxLength(20),
                Textarea::make('description'),
                Toggle::make('status')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('code')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('owner.firstname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tenant.firstname')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('monthly_payment')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([

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

    public static function getRelations(): array
    {
        return [
            //
        ];
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
