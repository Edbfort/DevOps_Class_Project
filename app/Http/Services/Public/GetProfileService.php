<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Models\Proyek;
use App\Models\Spesialisasi;
use App\Models\TransaksiPembuatanTeam;
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
            'media_sosial',
            'fee'
        ];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId($id);
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama_role == 'creative-hub-admin') {
            $select[] = 'email';
        } elseif ($userRoles->nama_role == 'controller') {
            $proyekQuery = Proyek::where([
                'id_controller' => $id
            ]);

            if (!is_null($proyekQuery->get())) {
                $data['projects_handled'] = count($proyekQuery->get());
            } else {
                $data['projects_handled'] = 0;
            }

            $proyekQuery->where([
                'id_status_proyek' => 6
            ]);

            if (!is_null($proyekQuery->get())) {
                if (count($proyekQuery->get()) != 0) {
                    $data['completion_rate'] = floor(count($proyekQuery->get()) / $data['projects_handled'] * 100);
                } else {
                    $data['completion_rate'] = 0;
                }
            } else {
                $data['completion_rate'] = 0;
            }
        }

        if ($id == Auth::id()) {
            $select = array_merge($select, [
                'email',
                'nomor_telepon',
                'alamat',
                'pengguna.id_status_pengguna'
            ]);

            if ($userRoles->nama_role == 'creative-hub-team') {
                $data['temp_password'] = TransaksiPembuatanTeam::where('id_user', $id)
                    ->first()
                    ->temp_password;

                $data['creative_hub_admin'] = TransaksiPembuatanTeam::select('users.nama as nama')->where('id_user', $id)
                    ->join('users', 'transaksi_pembuatan_team.id_cha', '=', 'users.id')
                    ->first()
                    ->nama;
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

        $result['data_pengguna']['spesialisasi'] = json_decode($result['data_pengguna']['spesialisasi'], true);

        $result['spesialisasi'] = Spesialisasi::select('nama')->get()->toArray();

        $result['status_boleh_edit'] = isset($data['id_status_pengguna']);

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
