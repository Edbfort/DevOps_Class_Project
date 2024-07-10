<?php

namespace App\Http\Services\Public;

use App\Models\FilterSpesialisasi;
use App\Models\Pengguna;
use App\Models\Proyek;
use App\Repositories\UserRolesRepository;
use Illuminate\Support\Facades\Auth;

class GetProyekListService
{
    public function handle($request)
    {
        $select = [
            'p.id as proyek_id',
            'p.judul_proyek as proyek_judul_proyek',
            'ucl.nama as client_nama',
            'uco.nama as controller_nama',
            'ut.nama as team_nama',
            'p.id_status_proyek',
            'p.perkembangan as proyek_perkembangan',
            'p.tanggal_tegat as proyek_tanggal_tegat'
        ];

        $userRepo = new UserRolesRepository();
        $userRoles = $userRepo->findOneUserRolesAndNameByUserId(Auth::id());
        if (!$userRoles) {
            return response()->json(['message' => 'Data tidak di temukan'], 404);
        }
        if ($userRoles->nama_role == 'creative-hub-team') {
            $select = array_merge($select, [



                'uco.lokasi as controller_lokasi',
                'p.anggaran as proyek_anggaran',
                'p.deskripsi_proyek as proyek_deskripsi_proyek',
                'p.spesialisasi as proyek_spesialisasi'
            ]);
        }
        $proyekQuery = Proyek::query();
        $proyekQuery->select($select);

        if ($request->has('keyword')) {
            $proyekQuery->where('spesialisasi', 'like', '%' . $request->kategori . '%', 'or');
        }

        if ($request->rentang_harga == 1) {
            $proyekQuery->where('anggaran', '<', 50000);
        } elseif ($request->rentang_harga == 2) {
            $proyekQuery->whereBetween('anggaran', [50000, 300000]);
        } elseif ($request->rentang_harga == 3) {
            $proyekQuery->where('anggaran', '>', 300000);
        }

        $proyek = $proyekQuery->get();

        $result = [
            'data_proyek' => $proyek->toArray(),
            'data_spesialisasi' => FilterSpesialisasi::all()->toArray(),
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil diambil'], 200);
    }
}
