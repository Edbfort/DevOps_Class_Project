<?php

namespace App\Http\Services\creativeHubTeam;

use App\Models\FilterSpesialisasi;
use App\Models\Pengguna;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;

class GetProyekService
{
    public function handle($request)
    {
        $pengguna = Pengguna::where('id', Auth::id())->first();

        $proyekQuery = Proyek::query();

        if ($request->has('kategori')) {
            $proyekQuery->where('spesialisasi', 'like', '%' . $request->kategori . '%');
        }

        if ($request->rentang_harga == 1) {
            $proyekQuery->where('anggaran', '<', 50000);
        } elseif ($request->rentang_harga == 2) {
            $proyekQuery->whereBetween('anggaran', [50000, 300000]);
        } elseif ($request->rentang_harga == 3) {
            $proyekQuery->where('anggaran', '>', 300000);
        }

        $proyek = $proyekQuery->get();

        $result = [
            'data_proyek' => $proyek->toArray(),
            'data_spesialisasi' => FilterSpesialisasi::all()->toArray(),
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil diambil'], 200);
    }
}
