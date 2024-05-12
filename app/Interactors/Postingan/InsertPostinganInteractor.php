<?php

namespace App\Interactors\Postingan;

use App\Models\PostinganProject;
use App\Repositories\PenggunaRepository;
use App\Repositories\PostinganProjectRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class InsertPostinganInteractor
{
    protected $postinganProjectRepository;
    protected $penggunaRepository;

    public function __construct
    (
        PostinganProjectRepository $postinganProjectRepository,
        PenggunaRepository $penggunaRepository,
    )
    {
        $this->postinganProjectRepository = $postinganProjectRepository;
        $this->penggunaRepository = $penggunaRepository;
    }

    public function insertPostinganProject($request)
    {
        $userId = Auth::id();
        $pengguna = $this->penggunaRepository->findByUserId($userId)->id;
        if($pengguna) {
            try{
                DB::beginTransaction();
                $postinganProject = new PostinganProject;
                $postinganProject->judul_postingan = $request->judul_postingan;
                $postinganProject->deskripsi_postingan = $request->deskripsi_postingan;
                $postinganProject->id_project = 1;
                $postinganProject->id_pengguna = $pengguna;
                $postinganProject->waktu_buat = new \DateTime();
                $postinganProject->waktu_ubah = new \DateTime();
    
                $postinganProject->save();
                DB::commit();
                return response()->json(['message' => 'Postingan berhasil ditambahkan'], 201);
            } catch(\Exception $e) {
                return response()->json(['error' => $e], 500);
            }
        }

    }
}
