<?php

namespace Cblink\FeiShu\Message;

use Cblink\FeiShu\Client;

class Message extends Client
{
    public function sendMessage($id, $card, $idType = 'open_id', $msg_type = 'interactive', $root_id = '', $update_multi = true)
    {
        return $this->httpPostJson('/message/v4/send', [
            $idType => $id,
            'msg_type' => $msg_type,
            'card' => $card,
            'root_id' => $root_id,
            'update_multi' => $update_multi,
        ]);
    }

    public function sendEphemeralMessage($chat_id, $id, $card, $idType = 'open_id', $msg_type = 'interactive')
    {
        return $this->httpPostJson('/ephemeral/v1/send', [
            'chat_id' => $chat_id,
            $idType => $id,
            'msg_type' => $msg_type,
            'card' => $card,
        ]);
    }

    public function deleteEphemeralMessage(string $message_id)
    {
        return $this->httpPostJson('/ephemeral/v1/delete', [
            'message_id' => $message_id,
        ]);
    }

    public function updateInteractiveMessage(string $token, array $card, $open_ids = [])
    {
        return $this->httpPostJson('/interactive/v1/card/update', [
            'token' => $token,
            'card' => array_merge($card, array_filter([
                'open_ids' => $open_ids,
            ])),
        ]);
    }
}