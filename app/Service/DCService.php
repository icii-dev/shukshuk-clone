<?php

namespace App\Service;

use Braintree\Http;
use GuzzleHttp\Client;

class DCService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('DC_BASE_URL') . (str_ends_with(env('DC_BASE_URL'), '/') ? '' : '/'),
            'headers' => [
                'access-key-id' => env('DC_ACCESS_KEY_ID'),
                'secret-access-key' => env('DC_SECRET_ACCESS_KEY'),
                'Accept' => 'application/json'
            ]
        ]);
    }

    public function postOrder($data){
        $response = $this->client->post('orders', [
            'json' => $data
        ]);
//        $responseBody = json_decode($response->getBody()->getContents(), true);
        return $response;
    }
}