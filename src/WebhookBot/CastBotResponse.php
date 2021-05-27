<?php

namespace Cblink\FeiShu\WebhookBot;

use Cblink\FeiShu\Exceptions\FeiShuBotResultException;
use Illuminate\Contracts\Support\Arrayable;
use ZhenMu\Support\Http\Response;

class CastBotResponse implements Arrayable
{
    protected $response;

    public function __construct(Response $response)
    {
        $this->response = $response;

        $this->validate();
    }

    public function validate()
    {
        $res = $this->response->toArray();

        if (empty($res)) {
            throw new FeiShuBotResultException($this->response->getBodyContents(), 500);
        }

        if (intval($res['StatusCode']) !== 0) {
            \info('FeiShuResultException', $res);
            throw new FeiShuBotResultException($res['StatusMessage'], $res['StatusCode']);
        }
    }

    public function toArray()
    {
        $res = $this->response->toArray();

        return $res['Extra'] ?? $res;
    }
}