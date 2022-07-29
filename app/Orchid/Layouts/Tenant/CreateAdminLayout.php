<?php

namespace App\Orchid\Layouts\Tenant;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Password;
use Orchid\Screen\Layouts\Rows;

class CreateAdminLayout extends Rows
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
            Input::make('tenant.admin.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Username'))
                ->placeholder(__('Username')),

            Input::make('tenant.admin.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),

            Password::make('tenant.admin.password')
                ->required()
                ->placeholder('Enter the password to be set')
                ->title(__('Password')),
        ];
    }
}
