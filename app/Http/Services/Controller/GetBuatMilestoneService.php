<?php

namespace App\Http\Services\Controller;

use App\Models\Milestone;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;

class GetBuatMilestoneService
{
    public function handle($request)
    {
        $proyek = Proyek::select([
            'proyek.id as proyek_id',
            'ut.id as team_id',
            'ut.nama as team_nama',
            'proyek.judul_proyek as proyek_judul_proyek',
            'proyek.anggaran as proyek_anggaran',
            'proyek.tanggal_tegat as proyek_tanggal_tegat',
        ])
            ->join('users as ut', 'ut.id', '=', 'proyek.id_team')
            ->where([
                'proyek.id' => $request->id_proyek,
                'id_controller' => Auth::id(),
                'id_status_proyek' => 4
            ])
            ->get()->first();

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        $milestoneArray = Milestone::where([
            'id_proyek' => $request->id_proyek,
        ])->get()->toArray();

        $persentase = 0;
        foreach ($milestoneArray as $milestone) {
            $persentase = $persentase + (int)$milestone->persentase;
        }

        $proyek['milestone_persentase'] = $persentase;

        return response()->json(['data' => $proyek, 'message' => 'Data berhasil di ambil'], 200);
    }
}
