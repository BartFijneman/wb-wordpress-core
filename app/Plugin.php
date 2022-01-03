<?php

namespace WbWordpressSso;

use WbWordpressSso\Http\V1\Controllers\LoginController;


class Plugin {

    public function __construct()
    {
        /*
         * Register controller
         */
        $loginController = new LoginController();
        $loginController->register();
    }

}
