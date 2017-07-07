<?php

Route::post(
    config('frontend-rights.route'),
    'TecBeast\FrontendRights\Http\Controllers\FrontendRightsController@access'
)->middleware(config('frontend-rights.middleware'));
