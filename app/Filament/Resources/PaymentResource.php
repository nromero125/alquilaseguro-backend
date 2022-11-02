<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\IconColumn;


class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('amount')->required()->numeric(),
                Select::make('property_id')
                    ->required()
                    ->searchable()
                    ->relationship('property', 'name'),
                Select::make('tenant_id')
                    ->required()
                    ->searchable()
                    ->relationship('tenant', 'firstname'),
                Select::make('payment_type')
                    ->options([
                        1 => 'Pago de propiedad',
                        2 => 'Pago a broker',
                        3 => 'Pago de aseguradora',
                    ])
                    ->required()
                    ->searchable(),                    
                    SpatieMediaLibraryFileUpload::make('voucher')->collection('voucher')->conversionsDisk('s3'),
                    DatePicker::make('paid_at')->required(),
                    Toggle::make('is_late')
                    ->required(),
                    Toggle::make('status')
                    ->required(),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('amount')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('paid_at')
                    ->sortable()
                    ->searchable(),
                    IconColumn::make('is_late')
                ->boolean()
                ->falseIcon('')
                ->trueColor('danger')
                ->trueIcon('heroicon-o-x-circle'),
                TextColumn::make('property.name')
                    ->sortable()
                    ->searchable(),
                    SpatieMediaLibraryImageColumn::make('voucher')->collection('voucher')->conversion('thumb'),




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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }    
}
