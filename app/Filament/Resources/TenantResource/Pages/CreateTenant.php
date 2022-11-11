<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.tenant', 1)]);
    }
}
