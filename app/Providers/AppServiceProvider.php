<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Glhd\Bits\Support\Livewire\SnowflakeSynth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::propertySynthesizer(SnowflakeSynth::class);
    }
}
