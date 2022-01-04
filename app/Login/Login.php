<?php

namespace WbWordpressSso\Login;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


class Login
{

    public static function register()
    {
        if(carbon_get_theme_option('wb_login_activate')) {

            wp_enqueue_style('custom-login', plugin_dir_url(__FILE__) . '/login.css');
            wp_enqueue_script('custom-login', plugin_dir_url(__FILE__) . '/login.css');

            add_action('login_enqueue_scripts', [new self, 'login_style']);

            add_filter('login_headerurl', [new self, 'login_logo']);
        }
    }


    function login_logo() {
        $url = 'https://webbedrijf.nl';

        if(carbon_get_theme_option('wb_login_logo_url') != '') $url = carbon_get_theme_option('wb_login_logo_url');

        return $url;
    }


    function login_style() {
        $buttonColor = '#4191F7';
        $logo = plugin_dir_url( __FILE__ ) . '/default_logo.svg';

        if(carbon_get_theme_option('wb_login_logo') != '') $logo = carbon_get_theme_option('wb_login_logo');
        if(carbon_get_theme_option('wb_login_button_color') != '') $buttonColor = carbon_get_theme_option('wb_login_button_color');

        ?>

        <style type="text/css">
            #login h1 a, .login h1 a {
                background-image: url('<?php echo $logo ?>');
            }
            html .login form .button-primary {
                background-color: <?php echo $buttonColor; ?> !important;
            }

            <?php
            echo carbon_get_theme_option('wp_login_custom_css');
            ?>
        </style>

        <?php
    }

}
