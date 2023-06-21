<?php

namespace Mtechke\Api;
class Content extends Service
{
    public function send ($options)
    {
        if (empty($options['to']) || empty($options['message'])) {
            return $this->error('recipient and message must be defined');
        }

        if (!is_array($options['to'])) {
            $options['to'] = [$options['to']];
        }

        $data = [
            'username' 	=> $this->username,
            'to' 		=> implode(",", $options['to']),
            'message' 	=> $options['message']
        ];

        if (array_key_exists('enqueue', $options) && $options['enqueue']) {
            $data['enqueue'] = 1;
        }

        if (empty($options['from'])) {
            return [
                'status' => 'error',
                'data' => 'from is required for premium SMS'
            ];
        } else {
            $data['from'] = $options['from'];
        }

        if (!empty($options['keyword'])) {
            $data['keyword'] = $options['keyword'];
        }

        if (!empty($options['linkId'])) {
            $data['linkId'] = $options['linkId'];
        }

        if (!empty($options['retryDurationInHours'])) {
            $data['retryDurationInHours'] = $options['retryDurationInHours'];
        }

        // turn off bulk sms mode
        $data['bulkSMSMode'] = 0;

        $response = $this->client->post('messaging', ['form_params' => $data ]);

        return $this->success($response);
    }
}