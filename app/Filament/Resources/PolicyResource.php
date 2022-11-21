<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PolicyResource\Pages;
use App\Models\Policy;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;

class PolicyResource extends Resource
{
    protected static ?string $model = Policy::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.policy', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(trans('messages.name'))
                    ->placeholder(trans('messages.name'))
                    ->required(),
                Textarea::make('description')
                    ->label(trans('messages.description'))
                    ->placeholder(trans('messages.description'))
                    ->required(),
                TextInput::make('validity')
                    ->label(trans('messages.validity'))
                    ->placeholder(trans('messages.validity'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(90)
                    ->required(),
                Select::make('insurance_id')
                    ->label(trans_choice('messages.insurance', 1))
                    ->required()
                    ->searchable()
                    ->relationship('insurance', 'name'),
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
                TextColumn::make('validity')
                    ->label(trans('messages.validity'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('insurance.name')
                    ->label(trans_choice('messages.insurance', 1))
                    ->sortable()
                    ->searchable(),
            ])->defaultSort('created_at', 'desc')
            ->actions([
                EditAction::make(),
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
            'index' => Pages\ListPolicies::route('/'),
            'create' => Pages\CreatePolicy::route('/create'),
            'edit' => Pages\EditPolicy::route('/{record}/edit'),
        ];
    }
}
