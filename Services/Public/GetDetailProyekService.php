<?php

namespace App\Http\Services\Public;

use App\Models\LamaranProyek;
use App\Models\Pengguna;
use App\Models\Proyek;
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
            'controller_fee',
            'team_fee',
            'tanggal_tegat'
        ])
            ->where('id', $id)->first();

        $result = [];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles || !$proyek) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        } elseif ($userRoles->nama_role != 'controller' && $userRoles->nama_role != 'creative-hub-admin') {
            if (!is_null($proyek->id_controller)) {
                $result['controller'] = Pengguna::join(
                    'users', 'users.id', '=', 'pengguna.id_user'
                )
                    ->select([
                        'id_user',
                        'spesialisasi',
                        'users.nama as nama_controller',
                        'users.lokasi'
                    ])
                    ->where('id_user', $proyek->id_controller)
                    ->first()->toArray();

                $proyekQuery = Proyek::where([
                    'id_controller' => $result['controller']['id_user']
                ]);

                if (!is_null($proyekQuery->get())) {
                    $result['controller']['projects_handled'] = count($proyekQuery->get());
                } else {
                    $result['controller']['projects_handled'] = 0;
                }

                $proyekQuery->where([
                    'id_status_proyek' => 6
                ]);

                if (!is_null($proyekQuery->get())) {
                    if (count($proyekQuery->get()) != 0) {
                        $result['controller']['completion_rate'] = floor(count($proyekQuery->get()) / $result['controller']['projects_handled'] * 100);
                    } else {
                        $result['controller']['completion_rate'] = 0;
                    }
                } else {
                    $result['controller']['completion_rate'] = 0;
                }
            }
        }

        $result['proyek'] = $proyek->toArray();
        $result['proyek']['lokasi_dokumen'] = 'upload/dokumen/proyek/' . $result['proyek']['lokasi_dokumen'];
        if (!(is_null($result['proyek']['controller_fee']) || is_null($result['proyek']['team_fee']))) {
            $result['proyek']['anggaran'] = floor(((int)$result['proyek']['anggaran'] * (int)$result['proyek']['controller_fee'] / 100) + (int)$result['proyek']['team_fee']);
        }

        unset($result['proyek']['id_controller'],);

        if ($userRoles->nama_role == 'controller' && $proyek->id_team == null) {
            $lamaran_proyek = LamaranProyek::select([
                'ut.id as team_id',
                'ut.nama as team_nama',
                'ucha.id as cha_id',
                'ucha.nama as cha_nama',
                'ucha.lokasi as team_lokasi',
            ])
                ->join('users as ut', 'ut.id', '=', 'lamaran_proyek.id_team')
                ->join('pengguna as pt', 'pt.id_user', '=', 'ut.id')
                ->join('transaksi_pembuatan_team as tpt', 'tpt.id_user', '=', 'ut.id')
                ->join('users as ucha', 'ucha.id', '=', 'tpt.id_cha')
                ->where(['id_proyek' => $id, 'lamaran_proyek.status' => 0])->get()->toArray();

            $result['lamaran_proyek'] = [];
            foreach ($lamaran_proyek as $item) {
                $proyekQuery = Proyek::where([
                    'id_team' => $item['team_id']
                ]);

                if (!is_null($proyekQuery->get())) {
                    $item['projects_handled'] = count($proyekQuery->get());
                } else {
                    $item['projects_handled'] = 0;
                }

                $proyekQuery->where([
                    'id_status_proyek' => 6
                ]);

                if (!is_null($proyekQuery->get())) {
                    if (count($proyekQuery->get()) != 0) {
                        $item['completion_rate'] = floor(count($proyekQuery->get()) / $item['projects_handled'] * 100);
                    } else {
                        $item['completion_rate'] = 0;
                    }
                } else {
                    $item['completion_rate'] = 0;
                }

                $result['lamaran_proyek'][] = $item;
            }
        }

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
