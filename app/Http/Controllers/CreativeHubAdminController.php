<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTeamRequest;
use App\Http\Requests\InsertTeamRequest;
use App\Http\Services\creativeHubTeam\GetTeamService;
use App\Http\Services\creativeHubTeam\InsertTeamService;
use http\Exception\InvalidArgumentException;

class CreativeHubAdminController extends Controller
{
    /**
     * Handle incoming request
     *
     * @param InsertTeamRequest $request
     * @param InsertTeamService $service
     */
    public function insertTeam(InsertTeamRequest $request, InsertTeamService $service)
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
}
