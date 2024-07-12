<?php

namespace App\Http\Services\Public;

use App\Models\FilterSpesialisasi;
use App\Models\Proyek;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetProyekListService
{
    public function handle($request)
    {
        $select = [
            'proyek.id as proyek_id',
            'proyek.judul_proyek as proyek_judul_proyek',
            'ucl.nama as client_nama',
            'uco.nama as controller_nama',
            'ut.nama as team_nama',
            'proyek.id_status_proyek as proyek_status_proyek',
            'proyek.perkembangan as proyek_perkembangan',
            'proyek.tanggal_tegat as proyek_tanggal_tegat',
            'proyek.anggaran as proyek_anggaran',
        ];

        $where = [];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }

        if ($userRoles->nama_role == 'creative-hub-team' && !$request->has('id_user')) {
            $select = array_merge($select, [
                'uco.lokasi as controller_lokasi',
                'proyek.deskripsi_proyek as proyek_deskripsi_proyek',
                'proyek.spesialisasi as proyek_spesialisasi'
            ]);
        } else {
            $select = array_merge($select, [
                'db.link_meeting',
                'db.lokasi_dokumen'
            ]);

            if ($userRoles->nama_role != 'controller') {
                $where = array_merge($where, [
                    'proyek.status = 2'
                ]);

                if ($userRoles->nama_role == 'creative-hub-team') {
                    $where = array_merge($where, [
                        'db.status = 1'
                    ]);
                }
            }
        }

        $proyekQuery = Proyek::query();
        $proyekQuery->select($select)
            ->join('users as ucl', 'ucl.id', '=', 'proyek.id_client')
            ->leftJoin('users as uco', 'uco.id', '=', 'proyek.id_controller')
            ->leftJoin('users as ut', 'ut.id', '=', 'proyek.id_team')
            ->leftJoin('design_breif as db', 'db.id_proyek', '=', 'proyek.id')
            ->where($where);
        if ($request->has('id_user')) {
            if ($request->id_user != Auth::id()) {
                return response()->json(['message' => 'Data tidak di temukan'], 404);
            }

            $proyekQuery->whereRaw($request->id_user . ' IN (proyek.id_client, proyek.id_controller, proyek.id_team)');
        } else {
            if ($request->has('keyword')) {
                $proyekQuery->whereRaw(
                    "(ucl.nama like '%" . $request->keyword .
                    "% OR uco.nama like '%" . $request->keyword .
                    "% OR ut.nama like '%" . $request->keyword .
                    "% OR proyek.spesialisasi like '%" . $request->keyword .
                    "% OR proyek.judul_proyek like '%" . $request->keyword .
                    "% OR proyek.deskripsi_proyek like '%" . $request->keyword .
                    "% OR uco.lokasi like '%" . $request->keyword . ")"
                );
            }

            if ($request->has('anggaran')) {
                $anggaranArray = json_decode($request->anggaran);

                $operatorArray = [
                    'lte' => '<=',
                    'gte' => '>=',
                ];
                foreach ($anggaranArray as $anggaran) {
                    $anggaran = explode('|', $anggaran);

                    if (count($anggaran) > 2) {
                        $anggaran = [(int)$anggaran[0], (int)$anggaran[2]];
                        sort($anggaran);

                        $proyekQuery->orWhereBetween('proyek.anggaran', $anggaran);
                    } else {
                        if (!is_null($operatorArray[$anggaran[1]])) {
                            $proyekQuery->orWhere('proyek.anggaran', $operatorArray[$anggaran[1]], (int)$anggaran[0]);
                        }
                    }
                }
            }

            if ($request->has('spesialisasi')) {
                $spesialisasiArray = json_decode($request->spesialisasi);

                foreach ($spesialisasiArray as $spesialisasi) {
                    $proyekQuery->orWhere('proyek.spesialisasi', 'like', $spesialisasi);
                }
            }
        }

        $proyek = $proyekQuery->get();

        $result = [
            'proyek' => $proyek->toArray(),
            'filter_spesialisasi' => FilterSpesialisasi::all()->toArray(),
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil diambil'], 200);
    }
}
