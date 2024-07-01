<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetProfileRequest;
use App\Http\Requests\InsertAccountRequest;
use App\Http\Services\Account\GetAccountService;
use App\Http\Services\Account\InsertAccountService;
use App\Http\Services\creativeHubTeam\GetProfileService;

class CreativeHubAdminController extends Controller
{
    protected $getAccountService;
    public function __construct
    (
        GetAccountService $getAccountService
    )
    {
        $this->getAccountService = $getAccountService;
    }

    /**
     * Handle incoming request
     *
     * @param InsertAccountRequest $request
     * @param InsertAccountService $service
     */

    public function insertNewTeam(InsertAccountRequest $request, InsertAccountService $service, $id)
    {
        return $service->handle($request, $id);
    }
}
