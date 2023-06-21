<?php

namespace Mtechke\Api;
use GuzzleHttp\Exception\RequestException;

class Token extends Service
{
    public function __construct($client, $username, $apiKey)
    {
        parent::__construct($client, $username, $apiKey);
    }

    public function getToken()
    {
        $data = [
            "username" => $this->username,
            "password" => $this->apiKey
        ];

        try {
            $response = $this->client->post("index.php/auth/token", ['json' => $data]);
            return $this->success($response);
        } catch (RequestException $e) {
            return $this->exception($e);
        }
    }
}