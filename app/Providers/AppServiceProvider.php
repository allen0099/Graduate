<?php

namespace App\Providers;

use App\Models\Accessory;
use App\Models\Cloth;
use App\Models\Order;
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
                if (Auth::user()->role === User::ADMIN) {
                    return [
                        'time_range' => TimeRange::all(),
                    ];
                }
                return null;
            },
            'inventory' => function () {
                $cloths = Cloth::all()->each(function ($item, $key) {
                    $item['quantity'] -= Order::where('cloth_id', $item['id'])->count();
                });
                $accessories = Accessory::all()->each(function ($item, $key) {
                    $item['quantity'] -= Order::where('accessory_id', $item['id'])->count();
                });
                return [
                    'accessory' => $accessories,
                    'cloth' => $cloths,
                ];
            },
            'flash' => fn() => [
                'success' => Session::get('success'),
            ],
        ]);
    }
}
