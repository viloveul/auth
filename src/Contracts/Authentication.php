<?php

namespace Viloveul\Auth\Contracts;

use Viloveul\Auth\Contracts\UserData as IUserData;

interface Authentication
{
    public function authenticate();

    /**
     * @param IUserData $data
     * @param $exp
     * @param $nbf
     */
    public function generate(IUserData $data, $exp = 3600, $nbf = 0);

    public function getPrivateKey();

    public function getPublicKey();

    public function getToken();

    /**
     * @param $privateKey
     */
    public function setPrivateKey($privateKey);

    /**
     * @param $publicKey
     */
    public function setPublicKey($publicKey);

    /**
     * @param $token
     */
    public function setToken($token);
}
