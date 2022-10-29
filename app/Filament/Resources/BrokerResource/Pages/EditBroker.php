<?php

namespace App\Filament\Resources\BrokerResource\Pages;

use App\Filament\Resources\BrokerResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBroker extends EditRecord
{
    protected static string $resource = BrokerResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
