<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMemberRequest;
use App\Http\Requests\InsertLamaranProyekRequest;
use App\Http\Requests\InsertMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Services\CreativeHubTeam\GetMemberService;
use App\Http\Services\CreativeHubTeam\InsertLamaranProyekService;
use App\Http\Services\CreativeHubTeam\InsertMemberService;
use App\Http\Services\CreativeHubTeam\UpdateMemberService;

class CreativeHubTeamController extends Controller
{
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

    /**
     * Handle incoming request
     *
     * @param InsertMemberRequest $request
     * @param InsertMemberService $service
     */

    public function insertMember(InsertMemberRequest $request, InsertMemberService $service)
    {
    return $service->handle($request);
    }

    /**
     * Handle incoming request
     *
     * @param UpdateMemberRequest $request
     * @param UpdateMemberService $service
     */

    public function updateMember(UpdateMemberRequest $request, UpdateMemberService $service)
    {
    return $service->handle($request);
    }

    /**
     * Handle incoming request
     *
     * @param InsertLamaranProyekRequest $request
     * @param InsertLamaranProyekService $service
     */
    public function insertLamaranProyek(InsertLamaranProyekRequest $request, InsertLamaranProyekService $service)
    {
    return $service->handle($request);
    }

    
}
