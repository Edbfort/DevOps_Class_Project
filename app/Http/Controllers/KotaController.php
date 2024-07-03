<?php

namespace App\Http\Controllers;

use App\Models\Kota;

class KotaController extends Controller
{
    public function getKota()
    {
        $kotaArray = Kota::select(['id', 'nama'])->distinct()->get();

        return response()->json(['data' => $kotaArray], 200);
    }
}
