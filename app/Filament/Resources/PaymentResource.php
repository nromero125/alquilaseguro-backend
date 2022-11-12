<?php

namespace App\Filament\Resources;

use App\Enums\PaymentTypes;
use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function getNavigationLabel(): string
    {
        return trans_choice('messages.payment', 2);
    }

    public static function form(Form $form): Form
    {
        $paymentTypes = array_map(
            fn ($item) => trans("paymentTypes.$item"),
            array_flip(PaymentTypes::options())
        );

        return $form
            ->schema([
                TextInput::make('amount')
                    ->label(trans('messages.amount'))
                    ->placeholder('0.00')
                    ->required()
                    ->numeric(),
                Select::make('property_id')
                    ->label(trans_choice('messages.property', 1))
                    ->required()
                    ->searchable()
                    ->relationship('property', 'name'),
                Select::make('tenant_id')
                    ->label(trans_choice('messages.tenant', 1))
                    ->required()
                    ->searchable()
                    ->relationship('tenant', 'firstname'),
                Select::make('payment_type')
                    ->label(trans('messages.paymentType'))
                    ->options($paymentTypes)
                    ->required()
                    ->searchable(),
                SpatieMediaLibraryFileUpload::make('voucher')
                    ->collection('voucher')
                    ->conversionsDisk('s3'),
                DatePicker::make('paid_at')
                    ->label(trans('messages.paidAt'))
                    ->required(),
                Toggle::make('is_late')
                    ->label(trans('messages.isLate'))
                    ->required()
                    ->default(false),
                Toggle::make('status')
                    ->label('Verificado')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->label(trans('messages.amount'))
                    ->sortable()
                    ->searchable(),
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
                TextColumn::make('property.name')
                    ->label(trans_choice('messages.property', 1))
                    ->sortable()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('voucher')
                    ->collection('voucher')
                    ->conversion('thumb'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
