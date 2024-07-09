<?php

namespace App\Http\Services\creativeHubTeam;

use App\Models\MemberTeam;
use App\Models\TransaksiPembuatanTeam;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetMemberService
{
    public function handle($id)
    {
        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        } elseif ($userRoles->nama_role != 'creative-hub-team') {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $select = [
            'nama',
            'jabatan',
            'role_team'
        ];

        $result = MemberTeam::select($select)
            ->where('id_team', $id)
            ->get()->toArray();

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
