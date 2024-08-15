<?php

namespace App\Http\Services\Public;

use App\Models\Milestone;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateAcceptMilestoneService
{
    public function handle($request)
    {
        $id = Auth::id();

        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_client' => $id,
            'id_status_proyek' => 5
        ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        $milestone = Milestone::where([
            'id' => $request->id_milestone,
            'id_proyek' => $request->id_proyek,
            'status' => 2
        ])
            ->first();

        $milestone->update([
            'status' => 3,
            'waktu_ubah' => new DateTime(),
        ]);

        return response()->json(['message' => 'Milestone berhasil diganti ke accepted'], 200);
    }
}
