<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMemberRequest;
use App\Http\Requests\GetProfileRequest;
use App\Http\Requests\UpdateClientDataRequest;
use App\Http\Services\creativeHubTeam\GetMemberService;
use App\Http\Services\CreativeHubTeam\GetTeamService;
use App\Http\Services\Public\UpdateProfileService;

class CreativeHubTeamController extends Controller
{
    /**
     * Handle incoming request
     *
     * @param GetProfileRequest $request
     * @param GetTeamService $service
     */

    public function getProfile(GetProfileRequest $request, GetTeamService $service, $id)
    {
        return $service->handle($request, $id);
    }

    /**
     * Handle incoming request
     *
     * @param  UpdateClientDataRequest $request
     * @param UpdateProfileService $service
     */

    public function updateProfile(UpdateClientDataRequest $request, UpdateProfileService $service, $id)
    {
        return $service->handle($request, $id);
    }

    /**
     * Handle incoming request
     *
     * @param GetMemberRequest $request
     * @param GetMemberService $service
     */

    public function getMember(GetMemberRequest $request, GetMemberService $service, $id)
    {
        return $service->handle($request, $id);
    }
}
