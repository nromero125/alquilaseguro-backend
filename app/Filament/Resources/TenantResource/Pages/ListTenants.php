<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.tenant', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }
}
