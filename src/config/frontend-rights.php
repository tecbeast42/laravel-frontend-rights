<?php

return [

    /**
     * Routes to restrict to certain roles/policies
     */
    'restricted_access' => [
        'resource' => ['authorization1', 'authorization2'],
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

];
