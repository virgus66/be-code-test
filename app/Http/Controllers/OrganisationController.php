<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganisation;
use App\Organisation;
use App\Services\OrganisationService;
use App\Transformers\OrganisationTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * @param OrganisationService $service
     *
     * @return JsonResponse
     */
    public function store(Request $req, OrganisationService $service): JsonResponse
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|min:2',
        ]);
        $errors = $validator->errors();

        if (sizeof($errors) > 0) {
            $errArray = [];
            foreach( $errors->all() as $message ) {
                $errArray[] = $message;
            }
            return response()->json(['errors' => $errArray]);
        }
        

        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($req->all());
        
        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    public function listAll(OrganisationService $service)
    {
        $organizations = $service->getOrganizationsList();
        
        return $organizations;
    }
}
