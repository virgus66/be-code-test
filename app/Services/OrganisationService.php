<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\Organisation\CreatedMail;
use App\Organisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Transformers\OrganisationTransformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();
        $organisation->name = $attributes['name'];
        $organisation->trial_end = Carbon::now()->addDays(30);
        $organisation->owner_user_id = Auth::user()->id;
        $organisation->save();

        //Send email
        $authUser = Auth::user()->email;
        Mail::to($authUser)->queue(new CreatedMail(
            "You've created new organisation",
            $organisation
        ));

        return $organisation;
    }

    /**
     * @param
     *
     * @return JsonResponse
     */

     public function getOrganizationsList(): JsonResponse
     {
        $filter = $_GET['filter'] ?? false;

        $Organisations = Organisation::all();
        $Organisation_Array = array();

        foreach ($Organisations->all() as $x) {
            $x = (new OrganisationTransformer)->transform($x);

            if ($filter !== false) {
                if ($filter == 'subbed') {
                    if ($x['subscribed'] == 1) {
                        array_push($Organisation_Array, $x);
                    }
                } else if ($filter == 'trail') {
                    if ($x['subscribed'] == 0) {
                        array_push($Organisation_Array, $x);
                    }
                } else {
                    array_push($Organisation_Array, $x);
                }
            } else {
                array_push($Organisation_Array, $x);
            }
        }

        return response()->json(['data' => $Organisation_Array]);
     }
}
