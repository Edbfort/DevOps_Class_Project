<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBuatMilestoneRequest;
use App\Http\Requests\InsertBuatMilestoneRequest;
use App\Http\Requests\UpdateDesignBriefRequest;
use App\Http\Services\Controller\GetBuatMilestoneService;
use App\Http\Services\Controller\InsertBuatMilestoneService;
use App\Http\Services\Controller\UpdateDesignBriefService;

class ControllerController extends Controller
{
    public function updateDesignBrief(UpdateDesignBriefRequest $request, UpdateDesignBriefService $service)
    {
        return $service->handle($request);
    }

    public function getBuatMilestone(GetBuatMilestoneRequest $request, GetBuatMilestoneService $service)
    {
        return $service->handle($request);
    }

    public function insertBuatMilestone(InsertBuatMilestoneRequest $request, InsertBuatMilestoneService $service)
    {
        return $service->handle($request);
    }
}
