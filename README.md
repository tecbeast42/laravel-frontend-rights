# Laravel Frontend Rights
A package for Laravel 5.1+ where you can restrict certain resources (eg. routes) to only be accessable by a user with the correct rights (roles/policies etc) accessable via an api (eg. for ajax-calls).
Useful for single page applications or frontend route access validation.

## Installation

Install from composer:
```
composer require tecbeast/laravel-frontend-rights
```

Add the service provider to the providers array in config/app.php:
```
'providers' => [

    ...

    TecBeast\FrontendRights\FrontendRightsServiceProvider::class,

],
```
> :warning: If you have a catchall route you will want to place the service provider before the RouteServiceProvider of your application. Otherwise the route will not be accessable.

Publish the config to your application:
```
php artisan vendor:publish --provider="TecBeast\FrontendRights\FrontendRightsServiceProvider"
```

## Configuration

You can configure the config-file in config/frontend-rights.php.

### restricted_access

An associative array of resources (eg. routes) with associated rights (roles/policies) for users that are allowed to access that resource.
The keys are the names of the resources and the values are arrays of allowed policies.
```
'restricted_access' => [
    'resource' => ['authorization1', 'authorization2'],
],
```

### route

The route that the application will use to access the controller.
```
'route' => '/api/v1/resource/access',
```

### middleware

An array of middleware or middleware groups that the above mentioned route will use (can be left empty if no middleware are wanted).
```
'middleware' => [
    'api'
],
```

## Usage

Create a policy for the User class:
(https://laravel.com/docs/5.4/authorization#creating-policies)

In your policy the name of the functions should be the same names that you assign to resources in restricted_access:
```
'restricted_access' => [
    'restricted-route' => ['admin'],
],
```
Would have the following function in UserPolicy (or the corresponding policy for your User class):
```
public function admin(User $user)
{
    return $user->isAdmin;
}
```

To check if a user have the rights to a resource you send a post request to the route specified in config/frontend-rights.php:
```
https://website.com/api/v1/resource/access
```
With a resource parameter with the name of the resource you want to check:
```
resource = 'restricted-route'
```

The response will be a string "true" if access is granted (if the user is admin in example) or "false" if access is denied (user is not admin in example).

Then in your frontend you can parse the value and determine what to do.

Only resources listed in restricted_access will be restricted (all other resources return "true"), like a blacklist with steps.


### SPA example
An example for SPA would be when you navigate to a new page or want to display only certain things on the page.
You can then send an AJAX-call with the route as resource and when you get a negative response you can choose to redirect, display an error or hide the things that the user are not allowed to see.