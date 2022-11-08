<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RealEstateResource\Pages;
use App\Models\Bank;
use App\Models\RealEstate;
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
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
class RealEstateResource extends Resource
{
    protected static ?string $model = RealEstate::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->placeholder('Name...')
                    ->maxLength(255),
                TextInput::make('contact_person')
                    ->placeholder('Contact person')
                    ->maxLength(255),
                TextInput::make('contact_phone')
                    ->placeholder('Contact phone')
                    ->maxLength(255),
                Textarea::make('address')
                    ->columnSpan('full')
                    ->required(),
                Select::make('bank_name')
                    ->options(Bank::query()->pluck('name', 'name'))
                    ->searchable(),
                TextInput::make('bank_account')
                    ->maxLength(255),
                    SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('logo')
                    ->conversionsDisk('s3'),
                Toggle::make('status'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('logo')
                    ->collection('logo')
                    ->conversion('thumb'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('rnc')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->sortable(),
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
            'index' => Pages\ListRealEstates::route('/'),
            'create' => Pages\CreateRealEstate::route('/create'),
            'edit' => Pages\EditRealEstate::route('/{record}/edit'),
        ];
    }
}
