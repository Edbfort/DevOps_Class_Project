<?php

namespace App\Http\Services\Public;

use App\Models\TransaksiPembuatanTeam;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetTeamService
{
    public function handle($id)
    {
        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $select = [
            'users.nama',
            'spesialisasi'
        ];

        if ($id == Auth::id()) {
            $select = array_merge($select, ['email', 'temp_password', 'status_ganti_password', 'pengguna.id_status_pengguna']);
        }

        $result = TransaksiPembuatanTeam::select($select)
            ->join('users', 'users.id', '=', 'transaksi_pembuatan_team.id_user')
            ->join('pengguna', 'users.id', '=', 'pengguna.id_user')
            ->where('id_cha', $id)
            ->get()->toArray();

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
