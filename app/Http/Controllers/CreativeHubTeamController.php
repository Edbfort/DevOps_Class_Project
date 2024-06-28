<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProfileRequest;
use App\Http\Requests\UpdateClientDataRequest;
use App\Http\Services\CreativeHubTeam\GetProfileService;
use App\Http\Services\client\UpdateProfileService;

class CreativeHubTeamController extends Controller
{
    /**
     * Handle incoming request
     *
     * @param GetProfileRequest $request
     * @param GetProfileService $service
     */

    public function getProfile(GetProfileRequest $request, GetProfileService $service, $id)
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
}
