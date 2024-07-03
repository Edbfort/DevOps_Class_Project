<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateProfileService
{
    public function handle($request)
    {
        $parameter = $request->all();
        $user = User::where('id', Auth::id())->first();
        $pengguna = Pengguna::where('id_user', Auth::id())->first();

        $user->update($parameter);
        $pengguna->update(array_merge($parameter, ['status' => 1]));

        return response()->json(['message' => 'Profile berhasil di update'], 200);
    }
}
