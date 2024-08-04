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
            'proyek.id_status_proyek as proyek_id_status_proyek',
            'sp.nama as status_proyek_nama',
            'proyek.perkembangan as proyek_perkembangan',
            'proyek.tanggal_tegat as proyek_tanggal_tegat',
            'proyek.anggaran as proyek_anggaran',
            'pco.fee as controller_fee',
            'proyek.spesialisasi as proyek_spesialisasi'
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
                'proyek.deskripsi_proyek as proyek_deskripsi_proyek'
            ]);

            $where = array_merge($where, [
                'proyek.id_status_proyek' => 1
            ]);
        } else {
            $select = array_merge($select, [
                'db.link_meeting',
                'db.lokasi_dokumen'
            ]);
        }

        $proyekQuery = Proyek::query();
        $proyekQuery->select($select)
            ->join('users as ucl', 'ucl.id', '=', 'proyek.id_client')
            ->leftJoin('users as uco', 'uco.id', '=', 'proyek.id_controller')
            ->leftJoin('pengguna as pco', 'pco.id_user', '=', 'uco.id')
            ->leftJoin('users as ut', 'ut.id', '=', 'proyek.id_team')
            ->leftJoin('design_breif as db', 'db.id_proyek', '=', 'proyek.id')
            ->join('status_proyek as sp', 'sp.id', '=', 'proyek.id_status_proyek')
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
                    "%' OR uco.nama like '%" . $request->keyword .
                    "%' OR ut.nama like '%" . $request->keyword .
                    "%' OR proyek.spesialisasi like '%" . $request->keyword .
                    "%' OR proyek.judul_proyek like '%" . $request->keyword .
                    "%' OR proyek.deskripsi_proyek like '%" . $request->keyword .
                    "%' OR uco.lokasi like '%" . $request->keyword . "')"
                );
            }

            if ($request->has('anggaran')) {
                $anggaranArray = json_decode($request->anggaran);

                $operatorArray = [
                    'lte' => '<=',
                    'gte' => '>=',
                ];

                $parameterAnggaran = '(';

                foreach ($anggaranArray as $anggaran) {
                    $anggaran = explode('|', $anggaran);

                    if (count($anggaran) > 2) {
                        $anggaran = [(int)$anggaran[0], (int)$anggaran[2]];
                        sort($anggaran);

                        $anggaran = (int)$anggaran[0] . " AND " . (int)$anggaran[1];

                        $parameterAnggaran = $parameterAnggaran . " (proyek.anggaran BETWEEN " . $anggaran . ") OR";
                    } else {
                        if (!is_null($operatorArray[$anggaran[1]])) {
                            $parameterAnggaran = $parameterAnggaran . " (proyek.anggaran " . $operatorArray[$anggaran[1]] . " " . $anggaran[0] . ") OR";
                        }
                    }
                }

                $parameterAnggaran = substr($parameterAnggaran, 0, strlen($parameterAnggaran) - 2) . ' )';

                $proyekQuery->whereRaw($parameterAnggaran);
            }

            if ($request->has('spesialisasi')) {
                $spesialisasiArray = json_decode($request->spesialisasi, true);

                $parameterSpesialisasi = '(';

                foreach ($spesialisasiArray as $spesialisasi) {
                    $parameterSpesialisasi = $parameterSpesialisasi . " proyek.spesialisasi LIKE '%" . $spesialisasi . "%' OR";
                }

                $parameterSpesialisasi = substr($parameterSpesialisasi, 0, strlen($parameterSpesialisasi) - 2) . ' )';

                $proyekQuery->whereRaw($parameterSpesialisasi);
            }
        }

        $proyek = $proyekQuery->get();

        if (is_null($proyek)) {
            $proyek['setup'] = [];
            $proyek['ongoing'] = [];
        } else {
            $proyek = $proyek->toArray();
            $proyek = array_map(function ($item) {
                if (is_null($item["proyek_spesialisasi"])) {
                    $item["proyek_spesialisasi"] = [];
                } else {
                    $item["proyek_spesialisasi"] = json_decode($item["proyek_spesialisasi"], true);
                }
                return $item;
            }, $proyek);

            $proyekTmp = [];
            $proyekTmp['setup'] = [];
            $proyekTmp['ongoing'] = [];
            foreach ($proyek as $item) {
                if (!in_array($item["proyek_id_status_proyek"], [5, 6])) {
                    $proyekTmp['setup'][] = $item;
                } else {
                    $proyekTmp['ongoing'][] = $item;
                }
            }
            $proyek = $proyekTmp;
            unset($proyekTmp);
        }

        $result = [
            'setup' => $proyek['setup'],
            'ongoing' => $proyek['ongoing'],
            'filter_spesialisasi' => FilterSpesialisasi::select('nama')->get()->toArray(),
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil diambil'], 200);
    }
}
