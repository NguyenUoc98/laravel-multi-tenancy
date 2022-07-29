<?php

namespace App\Orchid\Screens\Tenant;

use App\Models\Landlord\Tenant;
use App\Models\User;
use App\Orchid\Layouts\Tenant\CreateAdminLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class CreateAdminScreen extends Screen
{
    public $tenant;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Tenant $tenant): iterable
    {
        return [
            'tenant' => $tenant
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Create Admin For Tenant: ' . $this->tenant->name;
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.tenants',
        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(CreateAdminLayout::class)
                ->title(__('Profile Information'))
                ->description(__('Create admin account for tenant.')),
        ];
    }

    /**
     * @param Tenant $tenant
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function save(Tenant $tenant, Request $request)
    {
        $request->validate([
            'tenant.admin.name'     => [
                'required'
            ],
            'tenant.admin.email'    => [
                'required',
            ],
            'tenant.admin.password' => [
                'required',
            ],
        ]);

        $tenant->makeCurrent();
        User::createAdmin($request->input('tenant.admin.name'), $request->input('tenant.admin.email'), $request->input('tenant.admin.password'));

        Toast::success(__('Created admin user: ' . $request->input('tenant.admin.name') . ' with password: ' . $request->input('tenant.admin.password')));

        return redirect()->route('platform.systems.tenants');
    }
}
