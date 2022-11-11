<?php

namespace App\Filament\Resources\BrokerResource\Pages;

use App\Filament\Resources\BrokerResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBrokers extends ListRecords
{
    protected static string $resource = BrokerResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.broker', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTitle(): string
    {
        return trans_choice('messages.broker', 2);
    }
}
