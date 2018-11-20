<?php

namespace Viloveul\Auth\Contracts;

use Viloveul\Auth\Contracts\Value as IValue;

interface Token
{
    /**
     * @param IValue $value
     * @param $exp
     * @param $nbf
     */
    public function generate(IValue $value, $exp = 3600, $nbf = 60);

    public function getPrivateKey();

    public function getPublicKey();

    /**
     * @param $key
     */
    public function setPrivateKey($key);

    /**
     * @param $key
     */
    public function setPublicKey($key);
}
