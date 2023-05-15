<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Enums\PaymentTypes;
use App\Filament\Resources\PaymentResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeading(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.payment', 1)]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->label(trans('messages.delete', ['item' => trans_choice('messages.payment', 1)]))
                ->icon('heroicon-o-trash'),
        ];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.payment', 1)]);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        switch ($data['payment_type']) {
            case PaymentTypes::PROPERTY_PAYMENT->value:
                $data['owner_id'] = null;
                $data['broker_id'] = null;
                $data['insurance_id'] = null;
                break;
            case PaymentTypes::OWNER_PAYMENT->value:
                $data['tenant_id'] = null;
                $data['insurance_id'] = null;
                break;
            case PaymentTypes::BROKER_PAYMENT->value:
                $data['tenant_id'] = null;
                $data['property_id'] = null;
                $data['owner_id'] = null;
                $data['insurance_id'] = null;
                break;
            case PaymentTypes::INSURANCE_PAYMENT->value:
                $data['tenant_id'] = null;
                $data['property_id'] = null;
                $data['owner_id'] = null;
                $data['broker_id'] = null;
                break;
        }

        return $data;
    }
}
