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
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;

class ClaimResource extends Resource
{
    protected static ?string $model = Claim::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.claim', 2);
    }

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
                    ->placeholder('0.00')
                    ->required()
                    ->numeric(),
                Select::make('property_id')
                    ->label(trans_choice('messages.property', 1))
                    ->required()
                    ->searchable()
                    ->relationship('property', 'name'),
                Select::make('user_id')
                    ->label(trans_choice('messages.user', 1))
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
                    ->label(trans_choice('messages.user', 1))
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                ->enum([
                    1 => 'Rechazada',
                    2 => 'Nueva',
                    3 => 'En progreso',
                    4 => 'Completada',
                ])
                ->colors([
                    'primary',
                    'secondary' => 2,
                    'warning' => 3,
                    'success' => 4,
                    'danger' => 1,
                ]),
            ])->defaultSort('created_at', 'desc')
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
