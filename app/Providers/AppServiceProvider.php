<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Contract\InventoryInterface;
use App\Contract\OrdersInterface;
use App\Contract\ORInterface;
use App\Contract\PaymentsInterface;


// Services
use App\Services\InventoryServices;
use App\Services\OrdersServices;
use App\Services\ORService;
use App\Services\PaymentsServices;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public $bindings  = [
        InventoryInterface::class => InventoryServices::class,
        OrdersInterface::class => OrdersServices::class,
        PaymentsInterface::class => PaymentsServices::class,
        ORInterface::class => ORService::class
    ];
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
        RateLimiter::for("api",function(Request $request) {
            return Limit::perHour(60)
                    ->by(
                        $request->user()?->id ?: $request->ip()
                    );
        });
    }
}
