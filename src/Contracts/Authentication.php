<?php

namespace Viloveul\Auth\Contracts;

use Viloveul\Auth\Contracts\UserData;

interface Authentication
{
    /**
     * @param UserData $user
     */
    public function authenticate(UserData $user): void;

    /**
     * @param UserData $data
     * @param int      $exp
     * @param int      $nbf
     */
    public function generate(UserData $data, int $exp, int $nbf): string;

    public function getPrivateKey(): string;

    public function getPublicKey(): string;

    public function getToken(): string;

    public function getUser(): UserData;

    /**
     * @param string $privateKey
     */
    public function setPrivateKey(string $privateKey): void;

    /**
     * @param string $publicKey
     */
    public function setPublicKey(string $publicKey): void;

    /**
     * @param string $token
     */
    public function setToken(string $token): void;

    /**
     * @param UserData $user
     */
    public function setUser(UserData $user): void;

    /**
     * @param string $token
     */
    public function withToken(string $token): self;
}
