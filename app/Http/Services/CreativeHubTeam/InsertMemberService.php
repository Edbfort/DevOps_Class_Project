<?php

namespace App\Http\Services\CreativeHubTeam;

use App\Models\MemberTeam;
use Illuminate\Support\Facades\Auth;
use \App\Http\Requests\InsertMemberRequest;

class InsertMemberService
{
    /**
     * Summary of handle
     * @param InsertMemberRequest $service
     * @param int $id
     */
    public function handle(InsertMemberRequest $request)
    {
        $userId = Auth::id();

        $parameter = $request->validated();

        MemberTeam::create(array_merge($parameter, ['id_team' => $userId]));

        return response()->json(['message' => 'Member berhasil di tambah'], 200);
    }
}
