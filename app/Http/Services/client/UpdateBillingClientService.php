<?php

namespace App\Http\Services\client;

use App\Models\BillingClient;
use App\Models\ClientData;
use App\Models\Pengguna;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class UpdateBillingClientService
{
    public function handle($request)
    {
        $parameters = $request->all();
        $idPengguna = Pengguna::where('id_user', Auth::id())->first()->id;

        $billingClient = BillingClient::where('id_pengguna', $idPengguna)->first();
        if (isEmpty())

        $billingClient->update(array_merge(['id_pengguna', $idPengguna], $parameters));

        return response()->json(['message' => 'Billing info berhasil di update'], 200);
    }

}
