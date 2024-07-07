<?php

namespace App\Services;

use GuzzleHttp\Client;

class FonnteService
{
    protected $client;
    protected $apiKey;
    protected $sender;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FONNTE_API_KEY');
        $this->sender = env('FONNTE_SENDER');
    }

    public function sendWhatsAppMessage($to, $message)
    {
        $response = $this->client->post('https://api.fonnte.com/send', [
            'headers' => [
                'Authorization' => $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'target' => $to,
                'message' => $message,
                'countryCode' => 'ID',
                'delay' => 1,
                'schedule' => 'now',
                'sender' => $this->sender
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
