<?php
namespace TecBeast\FrontendRights\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use TecBeast\FrontendRights\Exceptions\TooManyModelsException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FrontendRightsController extends Controller
{
    public function access(Request $request)
    {
        $restrictedAccess = $this->getRestrictedAccessArray();
        $resource = $request->resource;
        $user = auth()->user();

        if (!array_key_exists($resource, $restrictedAccess)) {
            return "true";
        }

        if ($user === null) {
            return "false";
        }

        foreach ($restrictedAccess[$resource] as $access) {
            // If value is not set: only set model to the model class
            // If value is set: find model in db
            if ($request->value === null) {
                $model = $access['model'];
            } else {
                if ($request->property === null) {
                    $request->merge(['property' => config('frontend-rights.default_property')]);
                }

                $model = $access['model']::where($request->property, $request->value)->get();

                if ($model->count() > 1) {
                    throw new TooManyModelsException($request->property, $request->value);
                } else if ($model->count() === 0) {
                    throw (new ModelNotFoundException)->setModel($access['model'], [$request->property, $request->value]);
                } else {
                    $model = $model->first();
                }
            }

            if ($user->can($access['acl'], $model)) {
                return "true";
            }
        }

        return "false";
    }

    /**
     * Expands the config array to be one format:
     * [
     *     'restricted-route-name' => [['acl' => 'policy-function', 'model' => 'App\Model']],
     * ]
     * Also sets default models where appropriate
     * @return array
     */
    protected function getRestrictedAccessArray()
    {
        $restrictedAccessArray = config('frontend-rights.restricted_access');
        $newRestrictedAccessArray = [];

        foreach ($restrictedAccessArray as $restrictedRouteName => $policyArray) {
            $newPolicyArray = [];

            foreach($policyArray as $policy) {
                if (!is_array($policy)) {
                    $policy = [
                        'acl' => $policy,
                        'model' => config('frontend-rights.default_model')
                    ];
                } else {
                    if (!array_key_exists('model', $policy)) {
                        $policy['model'] = config('frontend-rights.default_model');
                    }
                }

                array_push($newPolicyArray, $policy);
            }

            $newRestrictedAccessArray[$restrictedRouteName] = $newPolicyArray;
        }

        return $newRestrictedAccessArray;
    }
}
