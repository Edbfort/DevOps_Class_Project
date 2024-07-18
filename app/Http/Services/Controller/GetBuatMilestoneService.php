<?php

namespace App\Http\Services\Controller;

use App\Models\Milestone;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;

class GetBuatMilestoneService
{
    public function handle($request)
    {
        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_controller' => Auth::id(),
            'id_status_proyek' => 4
        ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 200);
        }

        $milestoneArray = Milestone::where([
            'id_proyek' => $request->id_proyek,
        ])->all();

        $perkembangan = 0;
        foreach ($milestoneArray as $milestone) {
            $perkembangan = $perkembangan + (int)$milestone->persentase;
        }


        return response()->json(['message' => 'Design Brief berhasil di update'], 200);
    }
}
