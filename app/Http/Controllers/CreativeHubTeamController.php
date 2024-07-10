<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMemberRequest;
use App\Http\Requests\GetProyekListRequest;
use App\Http\Services\creativeHubTeam\GetMemberService;
use App\Http\Services\Public\GetProyekListService;

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
}
