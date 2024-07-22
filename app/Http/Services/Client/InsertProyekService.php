<?php

namespace App\Http\Services\Client;

use App\Models\Pengguna;
use App\Models\Proyek;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InsertProyekService
{
    public function handle($request)
    {
        $parameter['judul_proyek'] = $request->judul_proyek;

        // Create the Proyek record
        Proyek::create([
            'id_client' => Auth::id(),
            'judul_proyek' => $request->judul_proyek,
            'deskripsi_proyek' => $request->deskripsi_proyek,
            'spesialisasi' => $request->spesialisasi,
            'anggaran' => $request->anggaran,
            'tanggal_tegat' => $request->tanggal_tegat,
            'lokasi_dokumen' => $request->lokasi_dokumen,
            'waktu_buat' => new \DateTime(),
            'waktu_ubah' => new \DateTime(),
        ]);

        return response()->json(['message' => 'Project berhasil di insert'], 200);
    }
}
