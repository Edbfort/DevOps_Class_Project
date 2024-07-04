<?php

namespace App\Http\Services\Public;

use App\Models\BillingRekening;
use App\Models\Pengguna;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\Cloner\Data;

class GetBillingRekeningService
{
    public function handle($request)
    {
        $parameter = $request->all();

        $user = User::find(Auth::id());

        $pengguna = Pengguna::where('id_user', $user->id)->first();

        // find the billing rekening
        $billingRekening = BillingRekening::select(['id_bank','nomor_rekening','nama_pemilik'])->where(['id_pengguna' => $pengguna->id])->first();

        return response()->json(['data' => $billingRekening->toArray(),'message' => 'Data Billing Rekening berhasil di ambil'], 200);
    }
}
