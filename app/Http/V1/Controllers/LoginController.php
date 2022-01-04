<?php

namespace WbWordpressSso\Http\V1\Controllers;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


class LoginController
{

    public function register()
    {
        add_action( 'rest_api_init', function () {
            register_rest_route( 'wb-wordpress-sso/v1', '/create-link', [
                'methods' => 'POST',
                'callback' => [$this, 'createLink'],
            ] );
        } );

        add_action( 'rest_api_init', function () {
            register_rest_route( 'wb-wordpress-sso/v1', '/login', [
                'methods' => 'GET',
                'callback' => [$this, 'login'],
            ] );
        } );
    }


    public function createLink( $request ) {

        $this->authenticate($request);

        /*
         * Validation
         */
        if($request->get_param('email') == '' ||
            $request->get_param('first_name') == '' ||
            $request->get_param('last_name') == '' ||
            $request->get_param('role') == '') {

            $response = new \WP_REST_Response( $request );
            $response->set_data(['error' => 'Invalid data.']);
            $response->set_status( 422 );
            return $response;
        }

        $user = get_user_by_email($request->get_param('email'));
        if($user === false) {
            $userId = wp_insert_user([
                'user_login' => $request->get_param('email'),
                'user_pass' => $this->generateRandomString(12),
                'user_email' => $request->get_param('email'),
                'first_name' => $request->get_param('first_name'),
                'last_name' => $request->get_param('last_name'),
                'role' => $request->get_param('role')
            ]);
        }
        else {
            $userId = $user->ID;
        }

        $token = $userId . $this->generateRandomString(32);

        if ( get_option('permalink_structure') ) {
            $url = home_url() . '/wp-json/wb-wordpress-sso/v1/login?token=' . $token;
        }
        else {
            $url = home_url() . '?rest_route=/wb-wordpress-sso/v1/login&token=' . $token;
        }

        set_transient($token, $userId, 60);

        $response = new \WP_REST_Response( $request );
        $response->set_data(['url' => $url]);
        return $response;
    }


    public function login( $request ) {

        /*
         * Validation
         */
        if($request->get_param('token') == '') {

            $response = new \WP_REST_Response( $request );
            $response->set_data(['error' => 'Invalid data.']);
            $response->set_status( 422 );
            return $response;
        }

        $userId = get_transient($request->get_param('token'));

        wp_clear_auth_cookie();
        wp_set_current_user ( $userId );
        wp_set_auth_cookie  ( $userId );

        $redirect_to = user_admin_url();
        wp_safe_redirect( $redirect_to );
    }


    private function authenticate($request) {

        if($request->get_header('token') !== WB_WORDPRESS_SSO_TOKEN) {
            $response = new \WP_REST_Response( $request );
            $response->set_data(['error' => 'Token invalid.']);
            $response->set_status( 403 );
            return $response;
        }

    }


    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
