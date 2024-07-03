<?php

namespace App\Http\Services\Public;

use App\Models\Pengguna;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Auth;

class UpdateUserService
{
    public function handle($request)
    {
        $parameter = $request->all();
        $user = User::where('id', Auth::id())->first();

        $user->update(array_merge($parameter, ['status' => 1]));

        return response()->json(['message' => 'Profile berhasil di update'], 200);
    }
}
