<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Location Refereces of neededs Objects
    |--------------------------------------------------------------------------
    */
    
    'location' => [
        'Models' => [
            'user' => 'App/Models/User'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | This Package Table References
    |--------------------------------------------------------------------------
    */

    'tables' => [
        'roles' => 'roles',
        'role_user' => 'role_user',
        'permissions' => 'permissions',
        'permission_role' => 'permission_role',
    ],

    /*
    |--------------------------------------------------------------------------
    | Others Table References
    |--------------------------------------------------------------------------
    */

    'others-tables' => [
        'Models' => [
            'user' => [
                'username' => 'name',
                'email' => 'email',
                'password' => 'password'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Use Migrations
    |--------------------------------------------------------------------------
    */

    'migrate' => true,

];