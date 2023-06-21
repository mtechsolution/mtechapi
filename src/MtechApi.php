<?php

namespace Mtechke\Api;

use GuzzleHttp\Client;

class MtechApi
{

    const BASE_DOMAIN = "mtechcomm.co.ke";
    protected $username;
    protected $apiKey;
    protected $client;
    protected $tokenClient;
    public $baseUrl;

    public function __construct($username, $apiKey)
    {
        $baseDomain = self::BASE_DOMAIN;
        $this->baseUrl = "https://api.$baseDomain";
        $this->username = $username;
        $this->apiKey = $apiKey;

        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

        $this->tokenClient = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ]
        ]);

    }

    public function token()
    {
        return new Token($this->tokenClient, $this->username, $this->apiKey);
    }

    public function sms()
    {
        return new Sms($this->client, $this->username, $this->apiKey);
    }

}