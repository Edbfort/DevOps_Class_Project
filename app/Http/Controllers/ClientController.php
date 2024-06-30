<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProfileRequest;
use App\Http\Requests\UpdateBillingClientRequest;
use App\Http\Requests\UpdateClientDataRequest;
use App\Http\Services\client\GetBillingClientService;
use App\Http\Services\client\UpdateBillingClientService;
use App\Http\Services\Public\GetProfileService;
use App\Http\Services\Public\UpdateProfileService;

class ClientController extends Controller
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
     * @param UpdateClientDataRequest $request
     * @param UpdateProfileService $service
     */

    public function updateProfile(UpdateClientDataRequest $request, UpdateProfileService $service, $id)
    {
        return $service->handle($request, $id);
    }



    /**
     * Handle incoming request
     *
     * @param GetBillingClientService $service
     */

    public function getBilling(GetBillingClientService $service)
    {
        return $service->handle();
    }

    /**
     * Handle incoming request
     *
     * @param UpdateBillingClientRequest $request
     * @param UpdateBillingClientService $service
     */

    public function updateBilling(UpdateBillingClientRequest $request, UpdateBillingClientService $service)
    {
        return $service->handle($request);
    }
}
