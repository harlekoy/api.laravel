<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');

// Version 1 of our API
$api->version('v1', function (Router $api) {

    // Set our namespace for the underlying routes
    $api->group([
        'namespace'  => 'App\Api\Controllers',
        'middleware' => [
            'cors',
            'api.throttle',
        ],
        'limit'   => 100,
        'expires' => 5, ], function (Router $api) {

        // Login route
        $api->post('login', 'Auth\AuthController@authenticate');                                            // docs done
        $api->post('register', 'Auth\AuthController@register');

        $api->get('auth/refresh', [
            'middleware' => [
                'before' => 'jwt.auth',
                'after'  => 'jwt.refresh',
            ],
            function () {
                return response()->json(['code' => 200, 'text' => 'Token refreshed']);
            },
        ]);

        // All routes in here are protected and thus need a valid token
        $api->group(['protected' => true, 'middleware' => 'jwt.auth'], function (Router $api) {

            // Authentication
            $api->get('logout', 'Auth\AuthController@logout');                                              // docs done
            $api->get('validate_token', 'Auth\AuthController@validateToken');
            $api->get('users/me', 'Auth\AuthController@me');

            // Users
            $api->get('users', 'UserController@index');
            $api->get('users/profile/{user_id}', 'UserController@details');
            $api->get('users/profile', 'UserController@profile');
            $api->post('users/profile', 'UserController@store');
            $api->patch('users/profile/{user_id}', 'UserController@update');
            $api->delete('users/profile/{user_id}', 'UserController@destroy');
        });

    });

});
