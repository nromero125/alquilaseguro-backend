@if (filled($brand = config('filament.brand')))
    <div @class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
    <img src="{{ asset('/images/AlquilaSeguro_Logo.png') }}" alt="Logo" width="180">
    </div>
@endif
