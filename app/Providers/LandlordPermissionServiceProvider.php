<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class LandlordPermissionServiceProvider extends ServiceProvider
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
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group('System')
            ->addPermission('platform.systems.tenants', 'Tenants');

        $dashboard->registerPermissions($permissions);
    }
}
