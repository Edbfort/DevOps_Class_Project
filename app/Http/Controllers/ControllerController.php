<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetBuatMilestoneRequest;
use App\Http\Requests\InsertBuatMilestoneRequest;
use App\Http\Services\Controller\GetBuatMilestoneService;
use App\Http\Services\Controller\InsertBuatMilestoneService;

class ControllerController extends Controller
{
    public function getBuatMilestone(GetBuatMilestoneRequest $request, GetBuatMilestoneService $service)
    {
        return $service->handle($request);
    }

    public function insertBuatMilestone(InsertBuatMilestoneRequest $request, InsertBuatMilestoneService $service)
    {
        return $service->handle($request);
    }
}
