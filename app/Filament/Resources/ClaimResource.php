<?php

namespace App\Filament\Resources;

use App\Enums\ClaimStatus;
use App\Filament\Resources\ClaimResource\Pages;
use App\Models\Claim;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        $claimStatuses = array_map(
            fn ($item) => trans("claimStatus.$item"),
            array_flip(ClaimStatus::options())
        );

        return $form
            ->schema([
                TextInput::make('amount_to_claim')
                    ->label(trans('messages.amountToClaim'))
                    ->placeholder("0.00")
                    ->required()
                    ->numeric(),
                Select::make('property_id')
                    ->label(trans_choice('messages.property', 1))
                    ->required()
                    ->searchable()
                    ->relationship('property', 'name'),
                Select::make('insurance_id')
                    ->required()
                    ->searchable()
                    ->relationship('insurance', 'name'),
                Select::make('user_id')
                    ->label(trans('messages.user'))
                    ->required()
                    ->searchable()
                    ->relationship('user', 'name'),
                Textarea::make('description')
                    ->label(trans('messages.description'))
                    ->required(),
                SpatieMediaLibraryFileUpload::make('evidence')
                    ->label(trans('messages.evidence'))
                    ->multiple()
                    ->collection('evidence')
                    ->conversionsDisk('s3'),
                Select::make('status')
                    ->label(trans('messages.status'))
                    ->options($claimStatuses)
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount_to_claim')
                    ->label(trans('messages.amountToClaim'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('property.name')
                    ->label(trans_choice('messages.property', 1))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.name')
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
            ])
            ->bulkActions([]);
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
