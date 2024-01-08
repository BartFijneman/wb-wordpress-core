<?php

namespace WbWordpressCore\Page;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use DateTimeZone;


class Options
{

    public static function register()
    {
        add_action('carbon_fields_register_fields', [new self, 'settingsPage']);

        add_action('carbon_fields_theme_options_container_saved', [new self, 'saved']);
    }


    function saved() {

        $parts = parse_url($_SERVER['REQUEST_URI']);
        parse_str($parts['query'], $query);

        if($query['page'] === 'crb_carbon_fields_container_wb-core.php') {

            if ( wp_next_scheduled( 'wb_core_wpr_clear_cron' ) ) {
                wp_clear_scheduled_hook( 'wb_core_wpr_clear_cron');
            }

            if(carbon_get_theme_option('wb_core_wpr_clear') != 'none') {

                $at = '02:00';
                $day = 'sunday';

                date_default_timezone_set('Europe/Amsterdam');

                if( carbon_get_theme_option('wb_core_wpr_clear_at') != '' )
                    $at = carbon_get_theme_option('wb_core_wpr_clear_at');

                if( carbon_get_theme_option('wb_core_wpr_clear_at_day') != '' )
                    $day = carbon_get_theme_option('wb_core_wpr_clear_at_day');

                $time = strtotime('tomorrow ' . $at);

                if(carbon_get_theme_option('wb_core_wpr_clear') == 'weekly')
                    $time = strtotime('next ' . $day . ' ' . $at);

                wp_schedule_event($time, carbon_get_theme_option('wb_core_wpr_clear'), 'wb_core_wpr_clear_cron');
            }
        }
    }


    function settingsPage()
    {
        $wpCronNotice = '';

        if(!defined('DISABLE_WP_CRON') || DISABLE_WP_CRON != true) {
            $wpCronNotice = '<p style="color: red; ">LET OP! Het ziet er naar uit dat de server cronjob nog niet activeerd is. Doe dit alvorens je de optie \'Periodiek WP Rocket cache regenereren\' aanzet.</p>';
        }

        Container::make('theme_options', 'wb-core', __('Webbedrijf Core'))
            ->set_page_parent('options-general.php')
            ->add_tab('Login', [
                Field::make('text', 'wb_sso_key', 'SSO sleutel')
                    ->set_attribute('maxLength', 255)
                    ->set_attribute('readOnly', 'true')
                    ->set_default_value(defined('WB_WORDPRESS_SSO_TOKEN') ? WB_WORDPRESS_SSO_TOKEN : get_option('fallback-wb-wordpress-sso-token')),

                Field::make('checkbox', 'wb_login_activate', 'Login styling actief')
                    ->set_option_value('yes'),

                Field::make('color', 'wb_login_button_color', 'Knop achtergrond kleur')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make('color', 'wb_login_button_text_color', 'Knop tekst kleur')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make('color', 'wb_login_background_color', 'Achtergrond kleur')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make('color', 'wb_login_text_color', 'Tekst kleur')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make('image', 'wb_login_logo', 'Logo')
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]])
                    ->set_value_type( 'url' ),

                Field::make('text', 'wb_login_logo_url', 'Url achter logo')
                    ->set_attribute('maxLength', 255)
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]]),

                Field::make( 'textarea', 'wp_login_custom_css', 'Aangepaste css' )
                    ->set_conditional_logic([[
                        'field' => 'wb_login_activate',
                        'value' => true,
                    ]])
            ])
            ->add_tab('Caching', [
                Field::make( 'html', 'crb_information_text' )
                    ->set_html( '<p>Standaard wordt de cache in WP Rocket niet automatisch periodiek opnieuw gegenereerd. Je kunt hieronder automatisch regenereren activeren. Na het legen van de cache wordt alle content meteen weer voorgeladen. Controleer of de <a href="/wp-admin/options-general.php?page=wprocket#cache" target="_blank">Cache Lifespan</a> in WP Rocket op 0 staat. Dit is belangrijk, omdat de cache anders eerder kan verlopen. Daarnaast moet <a href="/wp-admin/options-general.php?page=wprocket#preload" target="_blank">preloaden</a> op basis van een sitemap geactiveerd zijn.</p>' . $wpCronNotice ),

                Field::make( 'select', 'wb_core_wpr_clear', __( 'Periodiek WP Rocket cache regenereren' ) )
                    ->add_options( array(
                        'none' => __( 'Niet legen' ),
                        'daily' => __( 'Dagelijks' ),
                        'weekly' => __( 'Wekelijks' ),
                    ) ),

                Field::make( 'select', 'wb_core_wpr_clear_at_day', __( 'Voorkeursdag' ) )
                    ->add_options( array(
                        'sunday' => __( 'Zondag' ),
                        'monday' => __( 'Maandag' ),
                        'tuesday' => __( 'Dinsdag' ),
                        'wednesday' => __( 'Woensdag' ),
                        'thursday' => __( 'Donderdag' ),
                        'friday' => __( 'Vrijdag' ),
                        'saturday' => __( 'Zaterdag' ),
                    ) )
                    ->set_conditional_logic([[
                        'field' => 'wb_core_wpr_clear',
                        'compare' => '=',
                        'value' => 'weekly',
                    ]]),

                Field::make( 'time', 'wb_core_wpr_clear_at', __( 'Voorkeurstijdstip' ) )
                    ->set_input_format( 'H:i', 'H:i' )
                    ->set_picker_options(['time_24hr' => true, 'enableSeconds' => false])
                    ->set_attribute( 'placeholder', '02:00' )
                    ->set_conditional_logic([[
                        'field' => 'wb_core_wpr_clear',
                        'compare' => '!=',
                        'value' => 'none',
                    ]])
            ]);
    }

}
