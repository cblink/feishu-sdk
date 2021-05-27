<?php

namespace Cblink\FeiShu\Bot;

use Cblink\FeiShu\Client;

class Bot extends Client
{
    public function info()
    {
        return $this->httpPostJson('/bot/v3/info');
    }
}