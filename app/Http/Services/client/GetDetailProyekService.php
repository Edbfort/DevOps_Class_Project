<?php

namespace App\Http\Services\client;

use App\Models\LamaranProyek;
use App\Models\Pengguna;
use App\Models\Proyek;
use App\Models\User;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetDetailProyekService
{
    public function handle($id)
    {
        $proyek = Proyek::select([
            'id_controller',
            'judul_proyek',
            'deskripsi_proyek',
            'spesialisasi',
            'lokasi_dokumen',
            'anggaran',
            'tanggal_tegat'
        ])
            ->where('id', $id)->first();

        $result['proyek'] = $proyek->toArray();
        unset($result['proyek']);

        $result = [];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles || !$proyek) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama_role != 'controller' || $userRoles->nama_role != 'creative-hub-admin') {
            $result['controller'] = Pengguna::select(['id_user', 'spesialisasi'])->where('id_user', $proyek->id_controller)->get()->toArray();
        }

        $result['lamaran_proyek'] = LamaranProyek::select([
            'ut.id as id_team',
            'ut.nama as nama_team',
            'ucha.id as id_cha',
            'ucha.nama as nama_cha',
            'ucha.lokasi as lokasi_team',
        ])
            ->join('users as ut', 'ut.id', '=', 'lamaran_proyek.id_team')
            ->join('pengguna as pt', 'pt.id_user', '=', 'ut.id')
            ->join('transaksi_pembuatan_team as tpt', 'tpt.id_user', '=', 'ut.id')
            ->join('users as ucha', 'ucha.id', '=', 'tpt.id_cha')
            ->where('id_proyek', $id)->get()->toArray();

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
