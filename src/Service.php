<?php

namespace Mtechke\Api;

class Service
{
    protected $client;

    protected $username;

    protected $apiKey;

    public function __construct($client, $username, $apiKey)
    {
        $this->client = $client;
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    protected static function error($data)
    {
        return [
            'status' => 'error',
            'errorCode' => $data->getStatusCode(),
            'data' => $data
        ];
    }

    protected static function validationError($data)
    {
        return [
            'status' => 'error',
            'errorCode' => 400,
            'data' => $data
        ];
    }

    protected static function exception($data)
    {
        return [
            'status' => 'error',
            'errorCode' => $data->getResponse()->getStatusCode(),
            'data' => $data->getResponse()->getBody()->getContents()
        ];
    }

    protected static function success($data)
    {
        return [
            'status' => 'success',
            'statusCode' => $data->getStatusCode(),
            'data' => json_decode($data->getBody()->getContents())
        ];
    }
}