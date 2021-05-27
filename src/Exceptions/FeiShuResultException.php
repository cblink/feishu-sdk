<?php

namespace Cblink\FeiShu\Exceptions;

class FeiShuResultException extends \Exception
{
    public function render()
    {
        dd($this->getMessage());
//        return  view('test', ['a' => $this->getMessage()]);
    }
}