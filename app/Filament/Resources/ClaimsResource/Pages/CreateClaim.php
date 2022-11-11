<?php

namespace App\Filament\Resources\ClaimResource\Pages;

use App\Filament\Resources\ClaimResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClaim extends CreateRecord
{
    protected static string $resource = ClaimResource::class;

    protected function getTitle(): string
    {
        return trans('messages.create', ['item' => trans_choice('messages.claim', 1)]);
    }
}
