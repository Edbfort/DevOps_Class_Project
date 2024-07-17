<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateDesignBriefRequest;
use App\Http\Services\Controller\UpdateDesignBriefService;

class ControllerController extends Controller
{
    public function updateDesignBrief(UpdateDesignBriefRequest $request, UpdateDesignBriefService $service)
    {
        return $service->handle($request);
    }
}
