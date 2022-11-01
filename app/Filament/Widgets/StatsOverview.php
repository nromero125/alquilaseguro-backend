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
        return [
            Card::make('Propiedades registradas', Property::count()),
            Card::make('Inquilinos registrados', Tenant::count()),
            Card::make('Brokers registrados', Broker::count()),
            Card::make('Inmobiliarias registradas', RealEstate::count()),
            Card::make('Pagos registrados', Payment::count()),
        ];
    }
}
