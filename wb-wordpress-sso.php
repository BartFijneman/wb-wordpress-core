<?php
/**
 * Plugin Name: Webbedrijf SSO
 * Plugin URI: https://github.com/BartFijneman/wb-wordpress-sso
 * Description: Webbedrijf SSO via portal
 * Version: 1.0.6
 * Author: Webbedrijf.nl
 * Author URI: https://webbedrijf.nl
 * License: GPL2
 */

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new WbWordpressSso\Plugin();


/*
 * Auto update
 */
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/BartFijneman/wb-wordpress-sso',
    __FILE__,
    'wb-wordpress-sso'
);

//Optional: Set the branch that contains the stable release.
$myUpdateChecker->setBranch('master');
