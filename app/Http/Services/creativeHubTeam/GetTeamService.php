<?php

namespace App\Http\Services\creativeHubTeam;

use App\Models\ClientData;
use App\Models\Pengguna;
use App\Models\ProfileTeam;
use App\Models\TransaksiPembuatanTeam;
use App\Models\User;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetTeamService
{
    public function handle($id)
    {
        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di  bang'], 404);
        } elseif ($userRoles->nama_role != 'creative-hub-admin') {
            return response()->json(['message' => 'Data tidak di temukan tai'], 404);
        }

        $select = [
            'users.nama',
            'spesialisasi'
        ];

        if ($id == Auth::id()) {
            $select = array_merge($select, ['email', 'temp_password', 'status_ganti_password']);
        }

        $result = TransaksiPembuatanTeam::select($select)
            ->join('users', 'users.id', '=', 'transaksi_pembuatan_team.id_user')
            ->join('pengguna', 'users.id', '=', 'pengguna.id_user')
            ->where('id_cha', $id)
            ->get()->toArray();

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
