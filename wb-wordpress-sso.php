<?php
/**
 * Plugin Name: Webbedrijf SSO
 * Plugin URI: https://github.com/BartFijneman/wb-wordpress-sso
 * Description: Webbedrijf SSO via portal
 * Version: 1.0.6
 * Author: Webbedrijf.nl
 * Author URI: https://webbedrijf.nl
 * License: GPL2
 * GitHub Plugin URI: https://github.com/BartFijneman/wb-wordpress-sso
 */

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new WbWordpressSso\Plugin();


/*
 * Auto update
 */
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/BartFijneman/wb-wordpress-sso/plugin.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'wb-wordpress-sso'
);
