<?php

namespace App\Http\Services\client;

use App\Models\Pembayaran;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;
use DateTime;

class UpdatePaymentProyekService
{
    public function handle($request)
    {
        $id = Auth::id();

        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_client' => $id,
            'id_status_proyek' => 3
        ])->first();

        if (!$proyek) {
            return response()->json(['message' => 'Gagal melakukan payment'], 422);
        }

        $data = Proyek::select([
            'pco.fee as controller_fee',
            'pt.fee as team_fee',
            'proyek.anggaran as anggaran'
        ])
            ->where([
                'proyek.id' => $request->id_proyek,
                'id_client' => $id,
                'id_status_proyek' => 3
            ])
            ->join('users as uco', 'uco.id', '=', 'proyek.id_controller')
            ->join('users as ut', 'ut.id', '=', 'proyek.id_team')
            ->join('pengguna as pco', 'pco.id_user', '=', 'uco.id')
            ->join('pengguna as pt', 'pt.id_user', '=', 'ut.id')
            ->get()->toArray()[0];

        $proyek->update([
            'controller_fee' => floor((int)$data['anggaran'] * (int)$data['controller_fee'] / 100),
            'team_fee' => (int)$data['team_fee'],
            'anggaran' => floor(((int)$data['anggaran'] * (int)$data['controller_fee'] / 100) + (int)$data['team_fee']),
            'waktu_ubah' => new DateTime(),
        ]);

        $pembayaran = Pembayaran::create([
            'id_user' => $id,
            'nominal' => $proyek->anggaran,
            'id_tipe_pembayaran' => 1,
            'waktu_buat' => new DateTime(),
            'waktu_ubah' => new DateTime(),
        ]);

        //Buang saat ada payment asli
        $pembayaran->update([
            'tanggal_pembayaran' => new DateTime(),
        ]);

        $proyek->update([
            'status_lunas' => 1,
            'id_status_proyek' => 4,
        ]);

        return response()->json(['message' => 'Payment berhasil dilakukan'], 200);
    }
}
