<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\User;
use App\Models\UserRoles;
use App\Repositories\UserRolesRepository;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


    /**
     * Register a User.
     *
     * @return JsonResponse
     */
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'nama' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|min:8|string',
            'lokasi' => 'required|string',
            'id_role' => 'required|integer'
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ];

            throw new ValidationException($validator, response()->json($response, 422));
        }

        try {
            DB::beginTransaction();

            $user = new User;
            $user->nama = request()->nama;
            $user->email = request()->email;
            $user->password = bcrypt(request()->password);
            $user->lokasi = request()->lokasi;
            $user->save();

            $pengguna = new Pengguna();
            $pengguna->id_user = $user->id;

            if (request()->id_role == 1 || request()->id_role == 4) {
                $pengguna->id_status_pengguna = 4;
            } else {
                $pengguna->id_status_pengguna = 1;
            }

            $pengguna->waktu_buat = new DateTime();
            $pengguna->waktu_ubah = new DateTime();
            $pengguna->save();

            $userRoles = new UserRoles();
            $userRoles->id_user = $user->id;
            $userRoles->id_role = request()->id_role;
            $userRoles->save();

            DB::commit();

            $credentials = request(['email', 'password']);

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['errors' => 'Unauthorized'], 401);
            }

            return response()->json(['data' => $this->respondWithToken($token)->original], 200);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['errors' => 'Terjadi kesalahan saat menyimpan data mohon hubungi IT Support Kami'], 500);
        }
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     */
    public function login()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|string',
            'password' => 'required|min:8|string',
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ];

            throw new ValidationException($validator, response()->json($response, 422));
        }

        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['errors' => 'Unauthorized'], 401);
        }

        return response()->json(['data' => $this->respondWithToken($token)->original], 200);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 5
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me()
    {
        try {
            $userInfo = response()->json(auth()->user());
            $userId = $userInfo->getData()->id;

            $userRepo = new UserRolesRepository();
            $userRoles = $userRepo->findOneUserRolesAndNameByUserId($userId);

            return response()->json(['data' => $userRoles, 'message' => 'successfully get the data'], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data mohon hubungi IT Support Kami'], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
