<?php

namespace WbWordpressCore;

use Carbon_Fields\Carbon_Fields;
use WbWordpressCore\Crons\WpRocketCache;
use WbWordpressCore\Http\V1\Controllers\LoginController;
use WbWordpressCore\Login\Login;
use WbWordpressCore\Page\Options;


class Plugin {

    public function __construct()
    {
        /*
         * Create fallback token
         */
        if(get_option('fallback-wb-wordpress-sso-token') == null) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $token = '';
            for ($i = 0; $i < 32; $i++) {
                $token .= $characters[rand(0, $charactersLength - 1)];
            }

            update_option('fallback-wb-wordpress-sso-token', $token);
        }

        add_action('after_setup_theme', [$this, 'loadCarbon']);

        add_action('carbon_fields_fields_registered', [$this, 'loadLogin']);

        /*
         * Register settings
         */
        Options::register();

        /*
         * Register controller
         */
        LoginController::register();

        /*
         * Register cronjobs
         */
        WpRocketCache::register();
    }


    function loadCarbon()
    {
        Carbon_Fields::boot();
    }


    function loadLogin() {
        Login::register();
    }

}
