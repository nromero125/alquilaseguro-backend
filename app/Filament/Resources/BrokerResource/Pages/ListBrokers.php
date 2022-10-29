<?php

namespace App\Filament\Resources\BrokerResource\Pages;

use App\Filament\Resources\BrokerResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrokers extends ListRecords
{
    protected static string $resource = BrokerResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
