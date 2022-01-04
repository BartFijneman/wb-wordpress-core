<?php

namespace WbWordpressCore\Page;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


class Options
{

    public static function register()
    {
        add_action('carbon_fields_register_fields', [new self, 'settingsPage']);
    }


    function settingsPage()
    {
        Container::make('theme_options', __('Webbedrijf SSO'))
            ->set_page_parent('options-general.php')
            ->add_fields([
                Field::make('checkbox', 'wb_login_activate', 'Login styling actief')
                    ->set_option_value('yes'),

                Field::make('color', 'wb_login_button_color', 'Aangepaste knop kleur')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make('image', 'wb_login_logo', 'Aangepaste logo')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]])
                    ->set_value_type( 'url' ),

                Field::make('text', 'wb_login_logo_url', 'Aangepaste logo url')
                    ->set_attribute('maxLength', 255)
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make( 'textarea', 'wp_login_custom_css', 'Aangepaste css' )
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),
            ]);
    }

}
