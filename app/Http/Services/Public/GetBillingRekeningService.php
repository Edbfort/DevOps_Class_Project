<?php

namespace App\Http\Services\Public;

use App\Models\Bank;
use App\Models\BillingRekening;
use Illuminate\Support\Facades\Auth;

class GetBillingRekeningService
{
    public function handle($request)
    {
        $bank = Bank::all()->toArray();

        // find the billing rekening
        $billingRekening = BillingRekening::select([
            'id_bank',
            'nomor_rekening',
            'nama_pemilik'
        ])
            ->where([
                'id_user' => Auth::id()
            ])
            ->get()->toArray();

        if (count($billingRekening)) {
            $billingRekening = $billingRekening->first();
        }

        $result = [
            'bank' => $bank,
            'bill_rekening' => $billingRekening
        ];

        return response()->json(['data' => $result, 'message' => 'Data Billing Rekening berhasil di ambil'], 200);
    }
}
