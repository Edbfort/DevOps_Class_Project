<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

class SmsController extends Controller
{
    public function sendSms()
    {
        $client = new Client();

        $response = $client->request('POST', 'https://rest.nexmo.com/sms/json', [
            'form_params' => [
                'api_key' => env('VONAGE_KEY'),
                'api_secret' => env('VONAGE_SECRET'),
                'from' => 'Kolab Aja',
                'to' => '6282391397268',
                'text' => 'Hello World!'
            ]
        ]);

        return response()->json(json_decode($response->getBody()->getContents()));
    }
}
