<?php

namespace App\Filament\Resources\TenantResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount'),
                TextColumn::make('paid_at')
                    ->label(trans('messages.paidAt'))
                    ->sortable()
                    ->searchable(),
                IconColumn::make('is_late')
                    ->label(trans('messages.isLate'))
                    ->boolean()
                    ->falseColor('danger')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->trueIcon('heroicon-o-check-circle'),
                TextColumn::make('created_at')
                ->label(trans('messages.created_at'))
                ->sortable()
                ->searchable(),
                TextColumn::make('property.name')
                    ->label(trans_choice('messages.property', 1))
                    ->sortable()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('voucher')
                    ->collection('voucher')
                    ->conversion('thumb'),

            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([

            ])
            ->bulkActions([

            ]);
    }
}
