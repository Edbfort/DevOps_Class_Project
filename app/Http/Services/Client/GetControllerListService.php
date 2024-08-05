<?php

namespace App\Http\Services\Client;

use App\Models\FilterSpesialisasi;
use App\Models\Pengguna;
use App\Models\Proyek;

class GetControllerListService
{
    public function handle($request)
    {
        $select = [
            'cu.id as id_user',
            'nama',
            'fee',
            'lokasi',
            'profil_detail',
            'spesialisasi'
        ];

        $controllerListQuery = Pengguna::query();
        $controllerListQuery->select($select)
            ->join('users as cu', 'cu.id', '=', 'pengguna.id_user')
            ->join('user_roles as ur', 'cu.id', '=', 'ur.id_user')
            ->where([
                'ur.id_role' => 2
            ]);

        if ($request->has('keyword')) {
            $controllerListQuery->whereRaw(
                "(cu.nama like '%" . $request->keyword .
                "%' OR cu.lokasi like '%" . $request->keyword .
                "%' OR pengguna.profil_detail like '%" . $request->keyword .
                "%' OR pengguna.spesialisasi like '%" . $request->keyword .
                "%' OR pengguna.fee like '%" . $request->keyword . "')"
            );
        }

        if ($request->has('fee')) {
            $feeArray = json_decode($request->fee);

            $operatorArray = [
                'lte' => '<=',
                'gte' => '>=',
                'equ' => '='
            ];

            $parameterFee = '(';

            foreach ($feeArray as $fee) {
                $fee = explode('|', $fee);

                if (count($fee) > 2) {
                    $fee = [(int)$fee[0], (int)$fee[2]];
                    sort($fee);

                    $fee = (int)$fee[0] . " AND " . (int)$fee[1];

                    $parameterFee = $parameterFee . " (pengguna.fee BETWEEN " . $fee . ") OR";
                } else {
                    if (!is_null($operatorArray[$fee[1]])) {
                        $parameterFee = $parameterFee . " (pengguna.fee " . $operatorArray[$fee[1]] . " " . $fee[0] . ") OR";
                    }
                }
            }

            $parameterFee = substr($parameterFee, 0, strlen($parameterFee) - 2) . ' )';

            $controllerListQuery->whereRaw($parameterFee);
        }

        if ($request->has('spesialisasi')) {
            $spesialisasiArray = json_decode($request->spesialisasi, true);

            $parameterSpesialisasi = '(';

            foreach ($spesialisasiArray as $spesialisasi) {
                $parameterSpesialisasi = $parameterSpesialisasi . " pengguna.spesialisasi LIKE '%" . $spesialisasi . "%' OR";
            }

            $parameterSpesialisasi = substr($parameterSpesialisasi, 0, strlen($parameterSpesialisasi) - 2) . ' )';

            $controllerListQuery->whereRaw($parameterSpesialisasi);
        }

        $controllerList = $controllerListQuery->get();

        if (is_null($controllerList)) {
            $controllerList = [];
        } else {
            $controllerList = $controllerList->toArray();
            $controllerList = array_map(function ($controller) {
                if (is_null($controller["spesialisasi"])) {
                    $controller["spesialisasi"] = [];
                } else {
                    $controller["spesialisasi"] = json_decode($controller["spesialisasi"], true);
                }

                $proyekArray = Proyek::where([
                    'id_controller' => $controller['id_user']
                ])
                    ->get();

                if (!is_null($proyekArray)) {
                    $controller['projects_handled'] = count($proyekArray);
                } else {
                    $controller['projects_handled'] = 0;
                }

                $controller['completion_rate'] = rand(80, 100);

                return $controller;
            }, $controllerList);
        }

        $result = [
            'list_controller' => $controllerList,
            'filter_spesialisasi' => FilterSpesialisasi::select('nama')->get()->toArray(),
        ];

        return response()->json(['data' => $result, 'message' => 'Data berhasil di ambil'], 200);
    }
}
