<?php

namespace App\Providers;

use App\Http\Controllers\OrderController;
use App\Models\Config;
use App\Models\Item;
use App\Models\TimeRange;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerInertia();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function registerInertia()
    {
        Inertia::version(fn() => md5_file(public_path('js/app.js')));

        Inertia::share([
            'title' => config('app.name'),
            'auth' => fn() => [
                'user' => Auth::user(),
            ],
            'configs' => function () {
                if (Auth::check()) {
                    return [
                        'time_range' => TimeRange::all(),
                        'location' => Config::getReturnLocationValue(),
                        'bachelor_price' => Config::getBachelorPrice()->value,
                        'master_price' => Config::getMasterPrice()->value,
                        'bachelor_margin_price' => Config::getBachelorMarginPrice()->value,
                        'master_margin_price' => Config::getMasterMarginPrice()->value,
                    ];
                }
                return null;
            },
            'inventory' => function () {
                return Item::all();
            },
            'orders' => function () {
                if (Auth::check()) {
                    if (Auth::user()->role === User::STUDENT) {
                        return OrderController::showOrders();
                    }
                }
                return null;
            },
            'flash' => fn() => [
                'success' => Session::get('success'),
            ],
        ]);
    }
}
