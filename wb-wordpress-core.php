<?php
/**
 * Plugin Name: Webbedrijf.nl core
 * Plugin URI: https://github.com/BartFijneman/wb-wordpress-core
 * Description: Integration for mijn.webbedrijf.nl
 * Version: 1.1.0
 * Author: Webbedrijf.nl
 * Author URI: https://webbedrijf.nl
 * License: GPL2
 */

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new WbWordpressCore\Plugin();


/*
 * Auto update
 */
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://github.com/BartFijneman/wb-wordpress-core',
    __FILE__,
    'wb-wordpress-core'
);

$myUpdateChecker->setBranch('master');
