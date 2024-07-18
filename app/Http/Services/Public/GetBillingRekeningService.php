<?php

namespace App\Http\Services\Public;

use App\Models\Bank;
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

        $user = Auth::id();

        $bank = Bank::all();

        // find the billing rekening
        $billingRekening = BillingRekening::select(['id_bank','nomor_rekening','nama_pemilik'])->where(['id_user' => $user])->first();

        $result = [
            'bank' => $bank->toArray(),
            'bill_rekening' =>$billingRekening ? $billingRekening->toArray(): null
        ];

        return response()->json(['data' => $result,'message' => 'Data Billing Rekening berhasil di ambil'], 200);
    }
}
