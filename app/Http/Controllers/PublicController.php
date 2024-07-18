<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdateBillingRekeningRequest;
use App\Http\Requests\GetBillingRekeningRequest;
use App\Http\Requests\GetDesignBriefRequest;
use App\Http\Requests\GetDetailProyekRequest;
use App\Http\Requests\GetMemberRequest;
use App\Http\Requests\GetProyekListRequest;
use App\Http\Requests\GetTeamRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\creativeHubTeam\GetMemberService;
use App\Http\Services\Public\CreateOrUpdateBillingRekeningService;
use App\Http\Services\Public\GetBillingRekeningService;
use App\Http\Services\Public\GetDesignBriefService;
use App\Http\Services\Public\GetDetailProyekService;
use App\Http\Services\Public\GetProfileService;
use App\Http\Services\Public\GetProyekListService;
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

    public function getDetailProyek(GetDetailProyekRequest $request, GetDetailProyekService $service, $id)
    {
        return $service->handle($id);
    }

    public function getProyekList(GetProyekListRequest $request, GetProyekListService $service)
    {
        return $service->handle($request);
    }

    public function getDesignBrief(GetDesignBriefRequest $request, GetDesignBriefService $service)
    {
        return $service->handle($request);
    }
}
