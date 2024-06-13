<?php

namespace App\Http\Controllers;

use App\Models\CreditCardInfo;
use App\Models\DataPribadi;
use App\Models\DataProductOwner;
use App\Models\Pengguna;
use App\Models\ProfileCompany;
use App\Models\ClientData;
use App\Models\UserRoles;
use App\Repositories\UserRolesRepository;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register() {
        $validator = Validator::make(request()->all(), [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'tanggal_lahir' => 'required|string',
            'jenis_kelamin' => 'required|boolean',
            'username' => 'string|max:20',
            'id_role' => 'required|integer'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try {
            DB::beginTransaction();

            $user = new User;
            $user->nama = request()->nama;
            $user->email = request()->email;
            $user->tanggal_lahir = request()->tanggal_lahir;
            $user->jenis_kelamin = request()->jenis_kelamin;
            $user->password = bcrypt(request()->password);
            $user->save();

            $pengguna = new Pengguna();
            $pengguna->id_user = $user->id;
            $pengguna->id_status_pengguna = 1;
            $pengguna->username = request()->username;
            $pengguna->uid = 800 . $user->id;
            $pengguna->waktu_buat = new \DateTime();
            $pengguna->waktu_ubah = new \DateTime();
            $pengguna->save();

            $userRoles = new UserRoles();
            $userRoles->id_user = $user->id;
            $userRoles->id_role_name = request()->id_role;
            $userRoles->save();

            if (request()->id_role == 1) {
                $profileCompany = new ProfileCompany();
                $profileCompany->id_pengguna = $pengguna->id;
                $profileCompany->waktu_buat = new \DateTime();
                $profileCompany->waktu_ubah = new \DateTime();
                $profileCompany->save();
            } elseif (request()->id_role == 2 or request()->id_role == 3) {
                $creditCardinfo = new CreditCardInfo();
                $creditCardinfo->id_pengguna = $pengguna->id;
                $creditCardinfo->waktu_buat = new \DateTime();
                $creditCardinfo->waktu_ubah = new \DateTime();
                $creditCardinfo->save();

                if (request()->id_role == 2) {
                    $dataProductOwner = new DataProductOwner();
                    $dataProductOwner->id_pengguna = $pengguna->id;
                    $dataProductOwner->waktu_buat = new \DateTime();
                    $dataProductOwner->waktu_ubah = new \DateTime();
                    $dataProductOwner->save();
                } elseif (request()->id_role == 3) {
                    $clientData = new ClientData(); 
                    $clientData->id_pengguna = $pengguna->id;
                    $clientData->waktu_buat = new \DateTime();
                    $clientData->waktu_ubah = new \DateTime();
                    $clientData->save();
                }
            }


            DB::commit();

            return response()->json(['message' => 'Akun berhasil terbuat'], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data mohon hubungi IT Support Kami'], 500);
        }

    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $userInfo = response()->json(auth()->user());
            $userId = $userInfo->getData()->id;

            $userRepo = new UserRolesRepository();
            $userRoles = $userRepo->findOneUserRolesAndNameByUserId($userId);

            return response()->json(['message' => $userRoles], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data mohon hubungi IT Support Kami'], 500);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60 * 5
        ]);
    }
}
