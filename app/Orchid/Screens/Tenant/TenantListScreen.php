<?php

namespace App\Orchid\Screens\Tenant;

use App\Models\Landlord\Tenant;
use App\Orchid\Layouts\Tenant\TenantListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class TenantListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tenants' => Tenant::query()
                ->defaultSort('id', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Tenants';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'All registered tenants';
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
            Link::make(__('Add'))
                ->icon('plus')
                ->class('btn py-1 border rounded-2 border-secondary')
                ->route('platform.systems.tenants.create'),
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
            TenantListLayout::class,
        ];
    }

    /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Tenant::findOrFail($request->get('id'))->delete();

        Toast::info(__('Tenant was removed'));
    }
}
