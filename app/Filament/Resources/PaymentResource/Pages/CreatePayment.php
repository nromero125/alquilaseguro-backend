<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeading(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.payment', 1)]);
    }

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['status'] = empty($data['status']) ? false : $data['status'];
        return $data;
    }
}
