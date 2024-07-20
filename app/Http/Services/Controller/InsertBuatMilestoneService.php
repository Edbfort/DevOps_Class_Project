<?php

namespace App\Http\Services\Controller;

use App\Models\Milestone;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;

class InsertBuatMilestoneService
{
    public function handle($request)
    {
        $proyek = Proyek::where([
                'id' => $request->id_proyek,
                'id_controller' => Auth::id(),
                'id_status_proyek' => 4
            ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        $milestoneArray = Milestone::where([
            'id_proyek' => $request->id_proyek,
        ])->all();

        $persentase = 0;
        foreach ($milestoneArray as $milestone) {
            $persentase = $persentase + (int)$milestone->persentase;
        }

        if (($persentase + abs($request->persentase)) > 100) {
            return response()->json(['message' => 'Persentase tidak boleh melebihi 100'], 422);
        }

        $milestone = Milestone::create([
            'id_proyek' => $request->id_proyek,
            'topik' => $request->topik,
            'deskripsi' => $request->deskripsi,
            'tautan' => $request->tautan,
            'persentase' => abs($request->persentase),
            'tanggal_tegat' => $request->tanggal_tegat,
            'status' => 0,
            'waktu_buat' => new \DateTime(),
            'waktu_ubah' => new \DateTime()
        ]);

        if (($persentase + abs($request->persentase)) == 100) {
            $milestone = Milestone::query();
            $milestone->where([
                'id_proyek' => $request->id_proyek
            ])
                ->orderBy('tanggal_tegat')
                ->first()
                ->update([
                    'status' => 1
                ]);

            $proyek->update([
                'id_status_proyek' => 5
            ]);
        }

        return response()->json(['data' => $proyek, 'message' => 'Data berhasil di ambil'], 200);
    }
}
