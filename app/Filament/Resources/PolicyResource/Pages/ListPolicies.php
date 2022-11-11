<?php

namespace App\Filament\Resources\PolicyResource\Pages;

use App\Filament\Resources\PolicyResource;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPolicies extends ListRecords
{
    protected static string $resource = PolicyResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make()
                ->label(trans('messages.create', ['item' => trans_choice('messages.policy', 1)]))
                ->icon('heroicon-o-plus'),
        ];
    }

    protected function getTitle(): string
    {
        return trans_choice('messages.policy', 2);
    }
}
