<?php


namespace App\Chat;


use GuzzleHttp\Client;

class SendBird
{
    private $client;

    private $baseUrl;

    function __construct()
    {
        $this->baseUrl = sprintf('https://api-%s.sendbird.com', env('SENDBIRD_APPLICATION_ID'));

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json, charset=utf8',
                'Api-Token' => env('SENDBIRD_API_TOKEN')
            ]
        ]);
    }

    public function post($uri, $data = [])
    {
        $response = $this->request(
            'post',
            $uri,
            [
                'body' => json_encode($data)
            ]);

        return $response;
    }

    public function put($uri, $data = [])
    {
        $response = $this->request(
            'put',
            $uri,
            [
                'body' => json_encode($data)
            ]);

        return $response;
    }

    public function get($uri)
    {
        $response = $this->request('get', $uri);

        return $response;
    }

    public function request($method, $uri, $options = [])
    {
        $options['http_errors'] =  false;

        $uri = 'v3/' . rtrim($uri, '/');

        $response = $this->client->request($method, $uri, $options);

        return $response;
    }
}
