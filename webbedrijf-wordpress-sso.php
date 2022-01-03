<?php
/**
 * Plugin Name: Webbedrijf SSO
 * Plugin URI: https://webbedrijf.nl
 * Description: Webbedrijf portal Wordpress SSO
 * Version: 1.0
 * Author: Webbedrijf.nl
 * Author URI: https://webbedrijf.nl
 * License: GPL2
 */

require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

new WebbedrijfSSO\Plugin();
