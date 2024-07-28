<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertTeamRequest;
use App\Http\Services\CreativeHubAdmin\InsertTeamService;

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
}
