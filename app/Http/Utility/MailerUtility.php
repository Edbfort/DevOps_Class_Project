<?php

namespace App\Services;

use Mailjet\Client;
use Mailjet\Resources;

class MailerUtility
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('MAILJET_APIKEY'), env('MAILJET_SECRETKEY'), true, ['version' => 'v3']);
    }

    public function sendEmail($recipients, $subject, $textPart, $htmlPart)
    {
        $body = [
            'FromEmail' => env('MAILJET_FROM_ADDRESS'),
            'FromName' => env('MAILJET_FROM_NAME'),
            'Recipients' => $recipients,
            'Subject' => $subject,
            'Text-part' => $textPart,
            'Html-part' => $htmlPart
        ];

        $response = $this->client->post(Resources::$Email, ['body' => $body]);
        return $response;
    }
}
