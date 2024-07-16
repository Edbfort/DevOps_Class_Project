<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetControllerListRequest;
use App\Http\Requests\InsertProyekRequest;
use App\Http\Requests\UpdateBillingClientRequest;
use App\Http\Requests\UpdateClientDataRequest;
use App\Http\Services\client\GetBillingClientService;
use App\Http\Services\client\GetControllerListService;
use App\Http\Services\client\InsertProyekService;
use App\Http\Services\client\UpdateBillingClientService;
use App\Http\Services\Public\UpdateProfileService;

class ClientController extends Controller
{
    /**
     * Handle incoming request
     *
     * @param InsertProyekRequest $request
     * @param InsertProyekService $service
     */
    public function insertProyek(InsertProyekRequest $request, InsertProyekService $service)
    {
        return $service->handle($request);
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

    /**
     * Handle incoming request
     *
     * @param GetControllerListRequest $request
     * @param GetControllerListService $service
     */

    public function getControllerList(GetControllerListRequest $request, GetControllerListService $service)
    {
        return $service->handle($request);
    }
}
