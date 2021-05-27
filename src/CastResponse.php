<?php

namespace Cblink\FeiShu;

use Cblink\FeiShu\Exceptions\FeiShuResultException;
use Illuminate\Contracts\Support\Arrayable;
use ZhenMu\Support\Http\Response;

class CastResponse implements Arrayable
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
            throw new FeiShuResultException($this->response->getBodyContents(), 500);
        }

        if (intval($res['code']) !== 0) {
            \info('FeiShuResultException', $res);
            throw new FeiShuResultException($res['msg'], $res['code']);
        }
    }

    public function toArray()
    {
        $res = $this->response->toArray();

        return $res['data'] ?? $res;
    }
}