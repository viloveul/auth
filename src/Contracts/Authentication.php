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
    public function generate(IUserData $data, $exp = 3600, $nbf = 0): string;

    public function getPrivateKey(): string;

    public function getPublicKey(): string;

    public function getToken(): string;

    /**
     * @param $privateKey
     */
    public function setPrivateKey(string $privateKey): void;

    /**
     * @param $publicKey
     */
    public function setPublicKey(string $publicKey): void;

    /**
     * @param $token
     */
    public function setToken(string $token): void;

    public function withToken(string $token): self;
}
