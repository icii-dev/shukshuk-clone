<?php

namespace App\Service;

use GuzzleHttp\Client;

class AnterajaService
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('ANTERAJA_BASE_URL') . (str_ends_with(env('ANTERAJA_BASE_URL'), '/') ? '' : '/'),
            'headers' => [
                'access-key-id' => env('ANTERAJA_ACCESS_KEY_ID'),
                'secret-access-key' => env('ANTERAJA_SECRECT_ACCESS_KEY'),
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    /**
     *
     *
     * @param string $origin Id
     * @param string $destination Id
     * @param int $weight Weight as gram (g)
     */
    public function serviceRate($origin, $destination, $weight)
    {
        $weight = max($weight, 1000);

        $body = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight
        ];

        $response = $this->client->post('serviceRates', [
            'body' => json_encode($body)
        ]);

        return $response;
    }

    public function order($data)
    {
        if (isset($data['parcel_total_weight'])) {
            $data['parcel_total_weight'] = max(1000, $data['parcel_total_weight']);
        }

        if (isset($data['shipper']['address'])) {
            $data['shipper']['address'] = str_pad($data['shipper']['address'], 10, '.');
        }

        if (isset($data['receiver']['address'])) {
            $data['receiver']['address'] = str_pad($data['receiver']['address'], 10, '.');
        }

        foreach ($data['items'] as &$item) {
            if ($item['weight'] < 100) {
                $item['weight'] = 100;
            }
        }

        $response = $this->client->post('order', [
            'body' => json_encode($data)
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        return $responseBody;
    }

    public function tracking($wayBillNo)
    {
        $body = [
            'waybill_no' => $wayBillNo
        ];

        $response = $this->client->post('tracking', [
            'body' => json_encode($body)
        ]);

        $responseBody = json_decode($response->getBody()->getContents(), true);

        return $responseBody;
    }

    public function isShippingEndStatus($shippingStatusCode)
    {
        return in_array($shippingStatusCode, [430, 250, 255]);
    }

    public function isShippingSucceed($shippingStatusCode)
    {
        return $shippingStatusCode == 250;
    }
}
