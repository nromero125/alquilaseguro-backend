<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Resources\Pages\EditRecord;

class EditClaim extends EditRecord
{
    protected static string $resource = ClaimResource::class;

    protected function getHeading(): string
    {
        return trans('messages.edit', ['item' => trans('messages.claim')]);
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getTitle(): string
    {
        return trans('messages.edit', ['item' => trans_choice('messages.claim', 1)]);
    }
}
