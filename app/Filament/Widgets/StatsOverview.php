<?php

namespace App\Filament\Widgets;

use App\Models\Broker;
use App\Models\Payment;
use App\Models\Property;
use App\Models\RealEstate;
use App\Models\Tenant;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $properties = Property::count();
        $tenants = Tenant::count();
        $brokers = Broker::count();
        $realEstates = RealEstate::count();
        $payments = Payment::count();

        return [
            Card::make(trans('messages.registeredItem', ['item' => trans_choice('messages.property', $properties)]), $properties),
            Card::make(trans('messages.registeredItem', ['item' => trans_choice('messages.tenant', $tenants)]), $tenants),
            Card::make(trans('messages.registeredItem', ['item' => trans_choice('messages.broker', $brokers)]), $brokers),
            Card::make(trans('messages.registeredItem', ['item' => trans_choice('messages.realEstate', $realEstates)]), $realEstates),
            Card::make(trans('messages.registeredItem', ['item' => trans_choice('messages.payment', $payments)]), $payments),
        ];
    }
}
