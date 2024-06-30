<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateProfileReuqest;
use App\Http\Services\Public\GetProfileService;
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
}
