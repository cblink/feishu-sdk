<?php

namespace Cblink\FeiShu\WebhookBot;

use Cblink\FeiShu\Client;
use Cblink\FeiShu\Encryptor;

class WebhookBot extends Client
{
    protected function signature(array $params, $secret = null)
    {
        if (!$secret) {
            return $params;
        }

        $timestamp = strtotime($date = date('Y-m-d H:i:s'));

        $signStr = sprintf("%s\n%s", $timestamp, $secret);
        $sign = Encryptor::hash_mac_sha256($signStr);
        $encodeStr = base64_encode($sign);

        $params['timestamp'] = $timestamp;
        $params['sign'] = $encodeStr;

        return $params;
    }

    public function getResponseType()
    {
        return CastBotResponse::class;
    }

    public function sendMessage($content, string $hook_id, $msg_type = 'text', $secret = null)
    {
        if ($msg_type === 'text') {
            $content['text'] = strval($content['text']);
        }

        return $this->httpPostJson(sprintf('/bot/v2/hook/%s', $hook_id), $this->signature([
            'msg_type' => $msg_type,
            'content' => $content,
        ], $secret));
    }
}