<?php

namespace App\Providers;

use App\Models\Landlord\Tenant;
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
        if (!Tenant::checkCurrent()) {
            $permissions = ItemPermission::group('Tenant')
                ->addPermission('platform.systems.tenants', 'Tenants');

            $dashboard->registerPermissions($permissions);
        }
    }
}
