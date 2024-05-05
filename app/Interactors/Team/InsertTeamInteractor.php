<?php

namespace App\Interactors\Team;

use App\Models\Team;
use App\Models\MemberTeam;
use App\Models\TeamJoinRequest;
use App\Repositories\PenggunaRepository;
use App\Repositories\TeamRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class InsertTeamInteractor
{
    protected $teamRepository;
    protected $penggunaRepository;
    protected $teamJoinRequestRepository;

    public function __construct
    (
        TeamRepository $teamRepository,
        PenggunaRepository $penggunaRepository,
        TeamJoinRequest $teamJoinRequestRepository
    )
    {
        $this->teamRepository = $teamRepository;
        $this->penggunaRepository = $penggunaRepository;
        $this->teamJoinRequestRepository = $teamJoinRequestRepository;
    }

    public function insertTeam($request)
    {
        $userId = Auth::id();
        $idPengguna = $this->penggunaRepository->findByUserId($userId)->id;
        try {
            DB::beginTransaction();
            $team = new Team();
            $team->pembuat = $idPengguna;
            $team->nama_team = $request->nama_team;
            $team->deskripsi = $request->deskripsi;
            $team->status_collab = $request->status_collab;
            $team->max_team = $request->max_team;
            $team->waktu_buat = new \DateTime();
            $team->waktu_ubah = new \DateTime();
            $team->save();

            $memberTeam = new MemberTeam();
            $memberTeam->id_team = $team->id;
            $memberTeam->id_pengguna = $userId;
            $memberTeam->jabatan = 'Owner';
            $memberTeam->waktu_buat = new \DateTime();
            $memberTeam->waktu_ubah = new \DateTime();
            $memberTeam->save();

            DB::commit();
            return response()->json(['message' => 'Berhasil Menambahkan Team'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal menambahkan team'], 500);
        }
    }

    public function joinTeam($id)
    {
        $userId = Auth::id();
        $idPengguna = $this->penggunaRepository->findByUserId($userId)->id;
        try {
            DB::beginTransaction();

            // Check if the user is already a member of the team
            $existingMember = MemberTeam::where('id_team', $id)
                ->where('id_pengguna', $idPengguna)
                ->exists();

            $existingRequest = TeamJoinRequest::where('id_team', $id)
                ->where('id_pengguna', $idPengguna)
                ->exists();

            if ($existingMember) {
                return response()->json(['error' => 'Kamu sudah berada di team ini'], 400);
            }
            if ($existingRequest) {
                return response()->json(['error' => 'Kamu pernah membuat permohonan ini'], 400);
            }

            $teamJoinRequest = new TeamJoinRequest();
            $teamJoinRequest->id_team = $id;
            $teamJoinRequest->id_pengguna = $idPengguna;
            $teamJoinRequest->status_terima = 0;
            $teamJoinRequest->waktu_buat = new \DateTime();
            $teamJoinRequest->waktu_ubah = new \DateTime();
            $teamJoinRequest->save();

            DB::commit();
            return response()->json(['message' => 'Berhasil Mengajukan Bergabung Dengan Team'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Gagal Bergabung Dengan team' . $e], 500);
        }
    }
}
