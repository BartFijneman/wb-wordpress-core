<?php

namespace WebbedrijfSSO;

use WebbedrijfSSO\Http\V1\Controllers\LoginController;


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
