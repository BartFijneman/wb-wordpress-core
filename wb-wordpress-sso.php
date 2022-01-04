<?php
/**
 * Plugin Name: Webbedrijf SSO
 * Plugin URI: https://github.com/BartFijneman/wb-wordpress-sso
 * Description: Webbedrijf SSO via portal
 * Version: 1.0.9
 * Author: Webbedrijf.nl
 * Author URI: https://webbedrijf.nl
 * License: GPL2
 */

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new WbWordpressSso\Plugin();


/*
 * Auto update
 */
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/BartFijneman/wb-wordpress-sso',
    __FILE__,
    'wb-wordpress-sso'
);

$myUpdateChecker->setBranch('master');
