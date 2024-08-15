<?php

namespace App\Http\Services\Public;

use App\Http\Utility\SmsUtility;
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
            'id_controller' => $id,
            'id_status_proyek' => 5
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
            'waktu_buat' => new DateTime(),
            'waktu_ubah' => new DateTime(),
        ]);

        $batchPembayaran = BatchPembayaran::create([
            'id_milestone' => $request->id_milestone,
            'id_pembayaran' => $pembayaran->id,
            'waktu_buat' => new DateTime(),
            'waktu_ubah' => new DateTime(),
        ]);

        $proyek->update([
            'perkembangan' => (int)$proyek->perkembangan + (int)$milestone->persentase,
            'waktu_ubah' => new DateTime(),
        ]);

        //Buang saat ada payment asli
        $pembayaran->update([
            'tanggal_pembayaran' => new DateTime(),
            'waktu_ubah' => new DateTime(),
        ]);

        $milestone->update([
            'status' => 4,
            'waktu_ubah' => new DateTime(),
        ]);

        $response = null;
        $response = SmsUtility::sendSms(
            '6289604884108',
            'Selamat, milestone "' . $milestone->topik . '" dari proyek "' .
            $proyek->judul_proyek . '", billing anda sudah menerima sebanyak nominal Rp.' . $pembayaran->nominal
        );

        $milestone = Milestone::query();
        $milestone->where([
            'id_proyek' => $request->id_proyek,
            'status' => 0
        ])
            ->orderBy('tanggal_tegat')
            ->first();

        if (empty($milestone)) {
            $proyek->update([
                'id_status_proyek' => 5,
                'waktu_ubah' => new DateTime(),
            ]);
        } else {
            $milestone->update([
                'status' => 1,
                'waktu_ubah' => new DateTime(),
            ]);
        }

        return response()->json(['data' => $response, 'message' => 'Milestone berhasil diganti ke terbayar'], 200);
    }
}
