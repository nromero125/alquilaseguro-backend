<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount_to_claim')->required()->numeric(),
                Select::make('property_id')
                    ->required()
                    ->searchable()
                    ->relationship('property', 'name'),
                Select::make('user_id')
                    ->required()
                    ->searchable()
                    ->relationship('user', 'name'),
                Textarea::make('description')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('evidence')->multiple()->collection('evidence')->conversionsDisk('s3'),
                Select::make('status')
                ->options([
                    1 => 'Activa',
                    2 => 'Nueva',
                    3 => 'En progreso',
                    4 => 'Completada',
                ])
                ->required()
                ->searchable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount_to_claim')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('property.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListClaim::route('/'),
            'create' => Pages\CreateClaim::route('/create'),
            'edit' => Pages\EditClaim::route('/{record}/edit'),
        ];
    }
}
