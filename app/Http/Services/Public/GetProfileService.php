<?php

namespace App\Http\Services\Public;

use App\Models\FilterSpesialisasi;
use App\Models\Pengguna;
use App\Models\TransaksiPembuatanTeam;
use App\Models\User;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetProfileService
{
    public function handle($id)
    {
        $data = [];

        $select = [
            'nama',
            'lokasi',
            'profil_detail',
            'website',
            'tag_line',
            'spesialisasi',
            'fee'
        ];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama == 'creative-hub-admin') {
            $select[] = 'email';
        }

        if ($id == Auth::id()) {
            $select = array_merge($select, [
                'email',
                'nomor_telepon',
                'alamat',
                'pengguna.id_status_pengguna'
            ]);

            if ($userRoles->nama_role == 'creative-hub-team') {
                if (User::where('id', $id)->first()->password)
                $data['temp_password'] = TransaksiPembuatanTeam::where('id_user', $id)
                    ->first()
                    ->temp_password;
            }
        }

        $pengguna = Pengguna::select($select)
            ->join('users', 'users.id', '=', 'pengguna.id_user')
            ->where('id_user', $id)
            ->first();

        if (!$pengguna) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

        $data = array_merge($data, $pengguna->toArray());

        $result['data_pengguna'] = $data;

        $result['spesialisasi'] = Spesialisasi::select('nama')->get()->toArray();

        $result['status_boleh_edit'] = isset($data['id_status_pengguna']);

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
