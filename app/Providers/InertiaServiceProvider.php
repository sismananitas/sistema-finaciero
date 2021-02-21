<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // User permissions
        Inertia::share('can', function () {
            if (!empty(Auth::user())) {
                return [
                    'index_users'        => Auth::user()->can('index_users'),
                    'index_roles'        => Auth::user()->can('index_roles'),
                    'index_accounts'     => Auth::user()->can('index_clients'),
                    'control_panel'      => Auth::user()->can('control_panel'),
                ];
            }
        });

        Inertia::share('taxes', function () {
            return [
                'iva' => 0.16,
            ];
        });

        // Navbar routes
        Inertia::share('navbar_routes', function () {
            return [
                [ 'name' => 'home', 'url' => '/home', 'text'=> 'Inicio' ],
                [ 'name' => 'accounts.index', 'url' => '/cuentas', 'text' => 'Cuentas' ],
            ];
        });
    }
}
