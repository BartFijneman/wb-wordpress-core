<?php

namespace WbWordpressSso;

use Carbon_Fields\Carbon_Fields;
use WbWordpressSso\Http\V1\Controllers\LoginController;
use WbWordpressSso\Login\Login;
use WbWordpressSso\Page\Options;


class Plugin {

    public function __construct()
    {

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
    }


    function loadCarbon()
    {
        Carbon_Fields::boot();
    }


    function loadLogin() {
        Login::register();
    }

}
