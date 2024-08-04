<?php

namespace App\Http\Services\Client;

use App\Http\Utility\UploadFileUtility;
use App\Models\Proyek;
use Illuminate\Support\Facades\Auth;
use DateTime;

class InsertProyekService
{
    public function handle($request)
    {
        $lokasiDokumen = null;
        if ($request->has('file_dokumen')) {
            $lokasiDokumen = UploadFileUtility::upload(
                $request->file('file_dokumen'),
                public_path('upload/dokumen/proyek')
            );

            if (!$lokasiDokumen) {
                return response()->json(['errors' => 'Terjadi kesalahan saat menyimpan data mohon hubungi IT Support Kami'], 500);
            }

            if (!$lokasiDokumen['status']) {
                return response()->json(['errors' => 'Terjadi kesalahan saat menyimpan data mohon hubungi IT Support Kami'], 500);
            }
        }

        // Create the Proyek record
        Proyek::create([
            'id_client' => Auth::id(),
            'judul_proyek' => $request->judul_proyek,
            'deskripsi_proyek' => $request->deskripsi_proyek,
            'spesialisasi' => $request->spesialisasi,
            'anggaran' =>  $request->anggaran,
            'tanggal_tegat' => $request->tanggal_tegat,
            'lokasi_dokumen' => $lokasiDokumen['fileName'],
            'waktu_buat' => new DateTime(),
            'waktu_ubah' => new DateTime(),
        ]);

        return response()->json(['message' => 'Project berhasil di insert'], 200);
    }
}
