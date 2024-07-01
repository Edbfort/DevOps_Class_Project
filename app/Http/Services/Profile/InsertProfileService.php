<?php

namespace App\Http\Services\Profile;

use App\Models\MemberTeam;
use App\Repositories\MemberTeamRepository;
use App\Repositories\PenggunaRepository;
use App\Repositories\ProfileCompanyRepository;
use App\Repositories\ProfileTeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsertProfileService
{
    protected $dataPribadiRepository;
    protected $userRepository;
    protected $profileCompanyRepository;
    protected $penggunaRepository;
    protected $profileTeamRepository;
    protected $memberTeamRepository;

    public function __construct
    (
        UserRepository $userRepository,
        ProfileCompanyRepository $profileCompanyRepository,
        ProfileTeamRepository $profileTeamRepository,
        PenggunaRepository $penggunaRepository,
        MemberTeamRepository $memberTeamRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->profileCompanyRepository = $profileCompanyRepository;
        $this->penggunaRepository = $penggunaRepository;
        $this->profileTeamRepository = $profileTeamRepository;
        $this->memberTeamRepository = $memberTeamRepository;
    }

    public function updateProfileAdmin($request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $idPengguna = $this->penggunaRepository->findByUserId($userId);

        try {
            DB::beginTransaction();
            $profileCompany = $this->profileCompanyRepository->findByIdPeserta($idPengguna->id);
            $profileCompany->nama = $request->nama;
            $profileCompany->tag_line = $request->tag_line;
            $profileCompany->jumlah_working_space = $request->jumlah_working_space;
            $profileCompany->nomor_telepon = $request->nomor_telepon;
            $profileCompany->alamat = $request->alamat;
            $profileCompany->website = $request->website;
            $profileCompany->deskripsi = $request->deskripsi;
            $profileCompany->visi_misi = $request->visi_misi;
            $profileCompany->save();
            DB::commit();
            return response()->json(['message' => 'Profile berhasil update'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }

    public function updateProfileTeam($request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $idPengguna = $this->penggunaRepository->findByUserId($userId)->id;

        $profileTeam = $this->profileTeamRepository->findOneByIdPengguna($idPengguna);

        try {
            DB::beginTransaction();
            $profileTeam->deskripsi = $request->deskripsi;
            $profileTeam->skillset = $request->skillset;
            $profileTeam->save();
            DB::commit();
            return response()->json(['message' => 'Profile Berhasil Di Update'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }


    //not tested yet
    public function insertTeamMember(Request $request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $idPengguna = $this->penggunaRepository->findByUserId($userId)->id;
        $profileTeam = $this->profileTeamRepository->findOneByIdPengguna($idPengguna);

        try {
            DB::beginTransaction();
            $memberTeam = new MemberTeam();
            $memberTeam->id_profile_team = $request->id_profile_team;
            $memberTeam->nama = $request->nama;
            $memberTeam->peran_team = $request->peran_team;
            $memberTeam->jabatan = $request->jabatan;
            $memberTeam->save();
            DB::commit();

            return response()->json(['message' => 'Team Berhasil Ditambah'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }

//    public function getTeamMembers()
//    {
//        $members = MemberTeam::all();
//        return response()->json($members, 200);
//    }

//    public function getTeamMember($id)
//    {
//        $member = MemberTeam::find($id);
//
//        if (!$member) {
//            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
//        }
//
//        return response()->json($member, 200);
//    }

    public function updateTeamMember(Request $request, $id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $member = MemberTeam::find($id);

        if (!$member) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();
            $member->id_profile_team = $request->id_profile_team;
            $member->nama = $request->nama;
            $member->peran_team = $request->peran_team;
            $member->jabatan = $request->jabatan;
            $member->save();
            DB::commit();

            return response()->json(['message' => 'Anggota berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }

    public function deleteTeamMember($id)
    {
        $userId = Auth::id();

        if ($id != $userId) {
            return response()->json(['errors' => 'Anda tidak memiliki akses untuk data ini'], 401);
        }

        $member = MemberTeam::find($id);

        if (!$member) {
            return response()->json(['message' => 'Anggota tidak ditemukan'], 404);
        }

        try {
            DB::beginTransaction();
            $member->delete();
            DB::commit();

            return response()->json(['message' => 'Anggota berhasil dihapus'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi Kesalahan'], 500);
        }
    }


}

