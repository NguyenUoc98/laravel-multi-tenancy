<?php

namespace App\Orchid\Screens\Tenant;

use App\Models\Landlord\Tenant;
use App\Orchid\Layouts\Tenant\TenantEditLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TenantEditScreen extends Screen
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
        return $this->tenant->exists ? 'Edit Tenant' : 'Create Tenant';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Details such as name, domain';
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
            Button::make(__('Remove'))
                ->icon('trash')
                ->class('btn btn-danger rounded')
                ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                ->method('remove')
                ->canSee($this->tenant->exists),

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
            TenantEditLayout::class,
        ];
    }

    /**
     * @param Tenant $tenant
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Tenant $tenant, Request $request)
    {
        $request->validate([
            'tenant.name'   => [
                'required',
                Rule::unique(Tenant::class, 'name')->ignore($tenant),
            ],
            'tenant.domain' => [
                'required',
                Rule::unique(Tenant::class, 'domain')->ignore($tenant),
            ],
        ]);

        $tenant
            ->fill($request->collect('tenant')->except(['tenant.name', 'tenant.domain'])->toArray())
            ->save();

        Toast::success(__('Tenant was saved.'));

        return redirect()->route('platform.systems.tenants');
    }
}
