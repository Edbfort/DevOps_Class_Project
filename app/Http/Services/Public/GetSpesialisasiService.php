<?php

namespace App\Http\Services\Public;

use App\Models\Spesialisasi;

class GetSpesialisasiService
{
    public function handle()
    {
        $spesialisasi = Spesialisasi::select('nama')->get()->toArray();

        return response()->json(['data' => $spesialisasi, 'message' => 'Data berhasil di ambil'], 200);
    }
}
