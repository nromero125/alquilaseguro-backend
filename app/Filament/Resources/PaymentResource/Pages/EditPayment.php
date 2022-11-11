<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.payment', 1)]);
    }
}
