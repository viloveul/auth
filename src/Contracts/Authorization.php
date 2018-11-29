<?php

namespace Viloveul\Auth\Contracts;

use Viloveul\Auth\Contracts\DataValue as IDataValue;

interface Authorization
{
    /**
     * @param $callback
     */
    public function authenticate(callable $callback = null);

    /**
     * @param IDataValue $value
     * @param $exp
     * @param $nbf
     */
    public function generate(IDataValue $value, $exp = 3600, $nbf = 60);

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
