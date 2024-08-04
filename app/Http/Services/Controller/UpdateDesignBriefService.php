<?php

namespace App\Http\Services\Controller;

use App\Http\Utility\UploadFileUtility;
use App\Models\DesignBreif;
use App\Models\Proyek;
use DateTime;
use Illuminate\Support\Facades\Auth;

class UpdateDesignBriefService
{
    public function handle($request)
    {
        $proyek = Proyek::where([
            'id' => $request->id_proyek,
            'id_controller' => Auth::id()
        ])->first();

        if ($proyek) {
            $lokasiDokumen = null;
            if ($request->has('file_dokumen')) {
                if (is_null($request->file('file_dokumen'))) {
                    $lokasiDokumen = UploadFileUtility::upload(
                        $request->file('file_dokumen'),
                        public_path('upload/dokumen/designBrief')
                    );

                    if (!$lokasiDokumen) {
                        return response()->json(['errors' => 'Terjadi kesalahan saat menyimpan data mohon hubungi IT Support Kami'], 500);
                    }
                }
            }

            $designBrief = DesignBreif::where([
                'id_controller' => Auth::id(),
                'id_proyek' => $request->id_proyek
            ])->first();

            if (!$designBrief) {
                if (is_null($lokasiDokumen)) {
                    return response()->json(['errors' => 'Dokumen harus di isi'], 422);
                }

                DesignBreif::create([
                    'id_controller' => Auth::id(),
                    'id_proyek' => $request->id_proyek,
                    'link_meeting' => $request->link_meeting,
                    'lokasi_dokumen' => $lokasiDokumen,
                    'status' => 0,
                    'waktu_buat' => new DateTime(),
                    'waktu_ubah' => new DateTime(),
                ]);
            } else {
                if ($designBrief->status == 0) {
                    $designBrief->update([
                        'link_meeting' => $request->link_meeting,
                        'lokasi_dokumen' => $lokasiDokumen,
                        'waktu_ubah' => new DateTime(),
                    ]);

                    if (!is_null($lokasiDokumen)) {
                        $designBrief->update([
                            'lokasi_dokumen' => $lokasiDokumen,
                        ]);
                    }
                } else {
                    return response()->json(['message' => 'Design Brief tidak dapat di update'], 422);
                }
            }
        } else {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        return response()->json(['message' => 'Design Brief berhasil di update'], 200);
    }
}
