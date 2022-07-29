<?php

namespace App\Orchid\Layouts\Tenant;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TenantEditLayout extends Rows
{
    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            Input::make('tenant.name')
                ->type('text')
                ->max(60)
                ->title('Name')
                ->placeholder('Name')
                ->required(),

            Input::make('tenant.domain')
                ->type('text')
                ->max(100)
                ->title('Domain')
                ->placeholder('Domain')
                ->required(),
        ];
    }
}
