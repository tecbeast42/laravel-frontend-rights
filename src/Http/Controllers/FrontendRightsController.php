<?php
namespace TecBeast\FrontendRights\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\User;

class FrontendRightsController extends Controller
{
    public function access(Request $request)
    {
        $restrictAccess = config('frontend-rights.restricted_access');
        $resource = $request->resource;
        $user = auth()->user();

        if (!array_key_exists($resource, $restrictAccess)) {
            return "true";
        }

        if ($user === null) {
            return "false";
        }

        foreach ($restrictAccess[$resource] as $access) {
            if ($user->can($access, User::class)) {
                return "true";
            }
        }

        return "false";
    }
}
