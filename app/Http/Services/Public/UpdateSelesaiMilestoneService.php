<?php

namespace App\Http\Services\Public;

use App\Models\Milestone;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateSelesaiMilestoneService
{
    public function handle($request)
    {
        $id = Auth::id();

        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_team' => $id,
            'id_status_proyek' => 4
        ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        $milestone = Milestone::where([
            'id' => $request->id_milestone,
            'id_proyek' => $request->id_proyek,
            'status' => 1
        ])
            ->first();

        $milestone->update([
            'info_perkembangan' => $request->info_perkembangan,
            'status' => 2,
            'waktu_ubah' => new DateTime(),
        ]);

        return response()->json(['message' => 'Milestone berhasil diganti ke selesai'], 200);
    }
}
