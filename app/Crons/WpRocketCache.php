<?php

namespace WbWordpressCore\Crons;


class WpRocketCache
{

    public static function register()
    {
        add_action( 'wb_core_wpr_clear_cron', function () {
            rocket_clean_domain();
            run_rocket_sitemap_preload();
        } );
    }

}
