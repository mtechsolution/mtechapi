<?php

namespace Mtechke\Api;
use GuzzleHttp\Exception\RequestException;

class Sms extends Service
{

    protected $allowedMessageTypes = ["Transactional", "Promotional"];

    public function __construct($client, $username, $apiKey)
    {
        parent::__construct($client, $username, $apiKey);
    }

    public function sendSms($options)
    {
        if (empty($options['msisdns'])) {
            return $this->validationError('At least one recipient must be defined');
        }

        if (empty($options["token"])) {
            return $this->validationError('Missing api token');
        }

        if (empty($options['message'])) {
            return $this->validationError('Message must be defined');
        }

        if (empty($options['message_id'])) {
            return $this->validationError('Missing message id');
        }

        if(empty($options['dlr_url']) || !filter_var($options['dlr_url'], FILTER_VALIDATE_URL)){
            return $this->validationError('Invalid delivery callback url');
        }

        if (empty($options["message_type"]) || !in_array($options["message_type"], $this->allowedMessageTypes)) {
            return $this->validationError('Invalid message type');
        }

        $data = [
            'message_id' => $options['message_id'],
            'username' => $this->username,
            'msisdns' => $options['msisdns'],
            'sender' => $options['sender'],
            'message_type' => $options['message_type'],
            'message' => $options['message'],
            'dlr_url' => $options['dlr_url']
        ];


        if (array_key_exists('encrypted', $options) && $options['encrypted']) {
            $data['encrypted'] = 1;
        } else {
            $data['encrypted'] = 0;
        }

        if (array_key_exists('encryption_method', $options) && $options['encryption_method']) {
            $data['encryption_method'] = "";
        }


        try {
            $response = $this->client->post('index.php/messaging/send', [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Bearer ' . $options["token"],
                    'Content-Type' => 'application/json',
                ]]);
            return $this->success($response);
        } catch (RequestException $e) {
            return $this->exception($e);
        }
    }
}