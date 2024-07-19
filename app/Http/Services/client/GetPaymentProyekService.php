<?php

namespace App\Http\Services\client;

use App\Models\Pembayaran;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class GetPaymentProyekService
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
            return response()->json(['message' => 'Payment tidak ditemukan'], 404);
        }

        $data = Proyek::select([
            'pco.fee as controller_fee',
            'pt.fee as team_fee',
            'proyek.anggaran as anggaran',
            'bc.nomor_kartu',
            'bc.nama_depan',
            'bc.nama_belakang'
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
            ->join('users as ucl', 'ucl.id', '=', 'proyek.id_client')
            ->join('billing_client as bc', 'bc.id_user', '=', 'ucl.id')
            ->get()->toArray()[0];

        $result = [
            'nominal' => floor(((int)$data['anggaran'] * (int)$data['controller_fee'] / 100) + (int)$data['team_fee']),
            'nomor_kartu' => substr($data['nomor_kartu'], 0, 4) . (str_repeat('*',max(0, (strlen($data['nomor_kartu'])) - 4))),
            'nama' => substr($data['nama_depan'], 0, 3) .
                (str_repeat('*', max(0, (strlen($data['nama_depan']) - 3)))) .
                '*' .
                (str_repeat('*', max(0, (strlen($data['nama_belakang']) - 3)))) .
                substr($data['nama_belakang'], strlen($data['nama_belakang']) - 4, 3)
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
