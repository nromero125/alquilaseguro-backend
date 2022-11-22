<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsuranceResource\Pages;
use App\Models\Bank;
use App\Models\Insurance;
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
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection;

class InsuranceResource extends Resource
{
    protected static ?string $model = Insurance::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.insurance', 2);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(trans('messages.name'))
                    ->required()
                    ->placeholder(trans('messages.name'))
                    ->maxLength(255),
                TextInput::make('email')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->placeholder('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('rnc')
                    ->label('RNC')
                    ->placeholder('RNC')
                    ->maxLength(15),
                TextInput::make('contact_person')
                    ->placeholder('Contact person')
                    ->maxLength(255),
                TextInput::make('contact_phone')
                    ->placeholder('Contact phone')
                    ->maxLength(255),
                Select::make('bank_name')
                    ->label(trans('messages.bankName'))
                    ->options(Bank::query()->pluck('name', 'name'))
                    ->searchable(),
                TextInput::make('bank_account')
                    ->label(trans('messages.bankAccount'))
                    ->maxLength(255),
                Toggle::make('status')
                    ->label(trans('messages.status'))
                    ->default(true),
                SpatieMediaLibraryFileUpload::make('logo')
                    ->collection('logo')
                    ->conversionsDisk('s3'),
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
                    ->label(trans('messages.name'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('rnc')
                ->sortable()
                ->searchable(),
                IconColumn::make('status')
                    ->label(trans('messages.status'))
                    ->boolean()
                    ->sortable()
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
            'index' => Pages\ListInsurances::route('/'),
            'create' => Pages\CreateInsurance::route('/create'),
            'edit' => Pages\EditInsurance::route('/{record}/edit'),
        ];
    }
}
