<?php

namespace App\Http\Services\CreativeHubTeam;

use App\Models\MemberTeam;
use Illuminate\Support\Facades\Auth;
use \App\Http\Requests\UpdateMemberRequest;

class UpdateMemberService
{
    /**
     * Summary of handle
     * @param UpdateMemberRequest $service
     * @param int $id
     */
    public function handle(UpdateMemberRequest $request)
    {
        $userId = Auth::id();

        $parameter = $request->validated();
        
        $memberTeam = MemberTeam::where('id',  $request->validated('id_member'));

        unset($parameter['id_member']);

        $memberTeam->update(array_merge($parameter, ['id_team' => $userId]));

        return response()->json(['message' => 'Member berhasil di ubah'], 200);
    }
}
