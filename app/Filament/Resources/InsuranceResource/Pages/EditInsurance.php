<?php

namespace App\Filament\Resources\InsuranceResource\Pages;

use App\Filament\Resources\InsuranceResource;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInsurance extends EditRecord
{
    protected static string $resource = InsuranceResource::class;

    protected function getHeading(): string
    {
        return trans('messages.edit', ['item' => trans('messages.insurance')]);
    }

    protected function getActions(): array
    {
        return [
            DeleteAction::make()
                ->label(trans('messages.delete', ['item' => trans('messages.insurance')]))
                ->icon('heroicon-o-trash'),
        ];
    }
}
