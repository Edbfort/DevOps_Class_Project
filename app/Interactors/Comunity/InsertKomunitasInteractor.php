<?php

namespace App\Interactors\Comunity;

use App\Models\Komunitas;
use App\Models\MemberKomunitas;
use App\Repositories\DataPribadiRepository;
use App\Repositories\KomunitasRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class InsertKomunitasInteractor
{
    protected $komunitasRepository;
    public function __construct
    (
        KomunitasRepository $komunitasRepository,
    )
    {
        $this->komunitasRepository = $komunitasRepository;
    }

    public function insertComunity($request)
    {
        $userId = Auth::id();
        try {
            DB::beginTransaction();
            $komunitas = new Komunitas();
            $komunitas->pembuat = $userId;
            $komunitas->nama_komunitas = $request->nama_komunitas;
            $komunitas->deskripsi = $request->deskripsi;
            $komunitas->waktu_buat = new \DateTime();
            $komunitas->waktu_ubah = new \DateTime();
            $komunitas->save();

            $memberKomunitas = new MemberKomunitas();
            $memberKomunitas->id_komunitas = $komunitas->id;
            $memberKomunitas->id_user = $userId;
            $memberKomunitas->jabatan = 'Owner';
            $memberKomunitas->waktu_buat = new \DateTime();
            $memberKomunitas->waktu_ubah = new \DateTime();
            $memberKomunitas->save();

            DB::commit();
            return response()->json(['message' => 'Berhasil Menambahkan Komunitas'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menambahkan komunitas'], 500);
        }
    }

    public function joinComunity($id)
    {
        $userId = Auth::id();
        try {
            DB::beginTransaction();

            // Check if the user is already a member of the community
            $existingMember = MemberKomunitas::where('id_komunitas', $id)
                ->where('id_user', $userId)
                ->exists();

            if ($existingMember) {
                return response()->json(['error' => 'User is already a member of this community'], 400);
            }

            $memberKomunitas = new MemberKomunitas();
            $memberKomunitas->id_komunitas = $id;
            $memberKomunitas->id_user = $userId;
            $memberKomunitas->jabatan = 'Member';
            $memberKomunitas->waktu_buat = new \DateTime();
            $memberKomunitas->waktu_ubah = new \DateTime();
            $memberKomunitas->save();

            DB::commit();
            return response()->json(['message' => 'Berhasil Bergabung Dengan Komunitas'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal Bergabung Dengan komunitas' . $e], 500);
        }
    }
}
