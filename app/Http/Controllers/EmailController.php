<?php

namespace App\Http\Controllers;

use Mailjet\Client;
use Mailjet\Resources;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $mj = new Client(env('MAILJET_APIKEY'), env('MAILJET_SECRETKEY'), true, ['version' => 'v3']);
        $body = [
            'FromEmail' => env('MAILJET_FROM_ADDRESS'),
            'FromName' => "Kolab aja",
            'Recipients' => [
                [
                    'Email' => "williamalim410@gmail.com",
                    'Name' => "Passenger 1"
                ]
            ],
            'Subject' => "Dana sudah di terima!",
            'Text-part' => "Dana anda sudah masuk berikut adalah recivenya!",
            'Html-part' => "<h3>1.000.000 rb!</h3>"
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        if ($response->success()) {
            return response()->json($response->getData());
        }

        return response()->json(['message' => 'Failed to send email'], 500);
    }
}
