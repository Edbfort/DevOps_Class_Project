<?php

namespace App\Http\Services\Public;

use App\Models\BatchPembayaran;
use App\Models\Milestone;
use App\Models\Pembayaran;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateTerbayarMilestoneService
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
            'status' => 3
        ])
            ->first();

        $batchPembayaran = BatchPembayaran::where([
            'id_milestone' => $request->id_milestone,
        ])->first();

        if ($batchPembayaran) {
            return response()->json(['message' => 'Milestone sudah terbayar'], 422);
        }

        $pembayaran = Pembayaran::create([
            'id_user' => $proyek->id_team,
            'nominal' => (int)((int)$proyek->team_fee * (int)$milestone->persentase / 100),
            'id_tipe_pembayaran' => 2,
            'waktu_buat' => new \DateTime(),
            'waktu_ubah' => new \DateTime(),
        ]);

        $batchPembayaran = BatchPembayaran::create([
            'id_milestone' => $request->id_milestone,
            'id_pembayaran' => $pembayaran->id,
            'waktu_buat' => new \DateTime(),
            'waktu_ubah' => new \DateTime(),
        ]);

        $milestone->update([
            'status' => 4,
            'waktu_ubah' => new DateTime(),
        ]);

        return response()->json(['message' => 'Milestone berhasil diganti ke terbayar'], 200);
    }
}
