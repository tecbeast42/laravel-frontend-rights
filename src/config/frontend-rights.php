<?php

return [

    /**
     * Routes to restrict to certain roles/policies
     */
    'restricted_access' => [
        // 'resource' => ['authorization1', 'authorization2'],
        // 'email.create' => [['acl' => 'create', 'model' => App\EmailAccount::class]],
    ],

    /**
     * The route for the controller
     */
    'route' => '/api/v1/resource/access',

    /**
     * Middlewares or middleware groups for the route
     */
    'middleware' => [
        'api'
    ],

    /**
     * Default model for the policy
     */
    'default_model' => App\User::class,

    /**
     * Default property when accessing a model (when no property is sent on request)
     */
    'default_property' => 'id',
];
