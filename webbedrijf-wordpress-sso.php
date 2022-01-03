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


/*
 * Auto update
 */
include_once('updater.php');

if (is_admin()) {
    $config = array(
        'slug' => plugin_basename(__FILE__),
        'proper_folder_name' => 'webbedrijf-wordpress-sso',
        'api_url' => 'https://api.github.com/repos/BartFijneman/wordpress-sso',
        'raw_url' => 'https://raw.github.com/BartFijneman/wordpress-sso/master',
        'github_url' => 'https://github.com/BartFijneman/wordpress-sso',
        'zip_url' => 'https://github.com/BartFijneman/wordpress-sso/zipball/master',
        'sslverify' => true,
        'requires' => '3.0',
        'tested' => '3.3',
        'readme' => 'README.md',
        'access_token' => ''
    );
    new WP_GitHub_Updater($config);
}
