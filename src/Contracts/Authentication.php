<?php

namespace Viloveul\Auth\Contracts;

use Viloveul\Auth\Contracts\UserData as IUserData;

interface Authentication
{
    /**
     * @param IUserData $user
     */
    public function authenticate(IUserData $user): IUserData;

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
    public function setPrivateKey($privateKey): void;

    /**
     * @param $publicKey
     */
    public function setPublicKey($publicKey): void;

    /**
     * @param $token
     */
    public function setToken($token): void;
}
