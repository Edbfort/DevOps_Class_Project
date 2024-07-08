<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateBillingRekeningRequest;
use App\Http\Requests\GetBillingRekening;
use App\Http\Requests\GetBillingRekeningRequest;
use App\Http\Requests\GetMemberRequest;
use App\Http\Requests\GetTeamRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateProfileReuqest;
use App\Http\Services\creativeHubTeam\GetMemberService;
use App\Http\Services\Public\CreateOrUpdateBillingRekeningService;
use App\Http\Services\Public\GetBillingRekeningService;
use App\Http\Services\Public\GetProfileService;
use App\Http\Services\Public\GetTeamService;
use App\Http\Services\Public\UpdateProfileService;

class PublicController extends Controller
{
    /**
     * Handle incoming request
     *
     * @param GetProfileService $service
     */
    public function getProfile(GetProfileService $service, $id)
    {
        return $service->handle($id);
    }

    /**
     * Handle incoming request
     *
     * @param UpdateProfileService $service
     * @param UpdateProfileRequest $request
     */
    public function updateProfile(UpdateProfileService $service, UpdateProfileRequest $request)
    {
        return $service->handle($request);
    }


    /**
     * Handle incoming request
     *
     * @param GetBillingRekeningService $service
     * @param GetBillingRekeningRequest $request
     */
    public function getRekening(GetBillingRekeningService $service, GetBillingRekeningRequest $request)
    {
        return $service->handle($request);
    }

    /**
     * Handle incoming request
     *
     * @param CreateOrUpdateBillingRekeningService $service
     * @param CreateOrUpdateBillingRekeningRequest $request
     */
    public function createOrUpdateRekening(CreateOrUpdateBillingRekeningService $service, CreateOrUpdateBillingRekeningRequest $request)
    {
        return $service->handle($request);
    }

    /**
     * Handle incoming request
     *
     * @param GetTeamRequest $request
     * @param GetTeamService $service
     */
    public function getTeam(GetTeamRequest $request, GetTeamService $service, $id)
    {
        return $service->handle($id);
    }

    /**
     * Handle incoming request
     *
     * @param GetMemberRequest $request
     * @param GetMemberService $service
     */

    public function getMember(GetMemberRequest $request, GetMemberService $service, $id)
    {
        return $service->handle($id);
    }
}
