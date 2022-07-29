<?php

namespace App\Orchid\Layouts\Tenant;

use App\Models\Landlord\Tenant;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TenantListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tenants';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->alignCenter()->sort(),
            TD::make('name', 'Name')->alignCenter(),
            TD::make('domain', 'Domain'),
            TD::make('database', 'Database'),
            TD::make('created_at', 'Created at')
                ->sort()
                ->render(function (Tenant $tenant) {
                    return $tenant->created_at->toDateTimeString();
                }),
            TD::make('updated_at', 'Updated at')
                ->sort()
                ->render(function (Tenant $tenant) {
                    return $tenant->updated_at->toDateTimeString();
                }),
            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Tenant $tenant) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([
                            Link::make(__('Edit'))
                                ->route('platform.systems.tenants.edit', $tenant->id)
                                ->icon('pencil'),

                            Link::make(__('Create Admin'))
                                ->route('platform.systems.tenants.create_admin', $tenant->id)
                                ->icon('user'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->class('text-danger btn btn-link')
                                ->confirm(__('Are you sure you want this tenant?'))
                                ->method('remove', [
                                    'id' => $tenant->id,
                                ]),
                        ]);
                }),
        ];
    }
}
