<?php

namespace Cblink\FeiShu\AccessToken;

use ZhenMu\Support\Traits\HasAttributes;

class Token
{
    use HasAttributes;

    public function __construct($token, $expire = 7200)
    {
        return $this->attributes = [
            'token' => $token,
            'expire' => $expire - 500,
        ];
    }
}