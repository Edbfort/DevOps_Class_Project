<?php

namespace App\Http\Controllers;

use App\Models\Milestone;

class KotaController extends Controller
{
    public function getKota()
    {
        $kotaArray = Milestone::select(['id', 'nama'])->distinct()->get();

        return response()->json(['data' => $kotaArray], 200);
    }
}
