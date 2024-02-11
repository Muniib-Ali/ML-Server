<?php

namespace App\Services;

use GuzzleHttp\Client;

class SlackService
{
    protected $httpClient;
    protected $webhookUrl;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->webhookUrl = env('SLACK_WEBHOOK_URL');
    }

    public function sendMessage($message, $channel = null)
    {
        $payload = [
            'text' => $message,
        ];

        if ($channel) {
            $payload['channel'] = $channel;
        }

        $response = $this->httpClient->post($this->webhookUrl, [
            'json' => $payload,
        ]);

        return $response->getStatusCode() === 200;
    }
}