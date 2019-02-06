<?php

namespace Viloveul\Auth;

use Exception;
use InvalidArgumentException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use RuntimeException;
use Viloveul\Auth\Contracts\Authentication as IAuthentication;
use Viloveul\Auth\Contracts\UserData as IUserData;
use Viloveul\Auth\InvalidTokenException;
use Viloveul\Auth\UserData;

class Authentication implements IAuthentication
{
    /**
     * @var mixed
     */
    protected $iss;

    /**
     * @var mixed
     */
    protected $keychain;

    /**
     * @var mixed
     */
    protected $passphrase = '';

    /**
     * @var mixed
     */
    protected $privateKey = '';

    /**
     * @var mixed
     */
    protected $publicKey = '';

    /**
     * @var mixed
     */
    protected $signer;

    /**
     * @var mixed
     */
    protected $token = '';

    /**
     * @var mixed
     */
    protected $user;

    /**
     * @param $passphrase
     * @param $iss
     */
    public function __construct($passphrase, $iss = null)
    {
        $this->passphrase = $passphrase;
        $this->iss = $iss;
        $this->signer = new Sha256();
        $this->keychain = new Keychain();
    }

    /**
     * @param IUserData $user
     */
    public function authenticate(IUserData $user = null): void
    {
        try {
            $parser = new Parser();
            $data = new ValidationData();
            $parsedToken = $parser->parse($this->getToken());
            $key = $this->keychain->getPublicKey("file://{$this->getPublicKey()}");
            if ($parsedToken->verify($this->signer, $key) !== true) {
                throw new Exception("The token cannot be verified.");
            }
            if ($parsedToken->validate($data) !== true) {
                throw new Exception("The token cannot be validated.");
            }
            $claims = $parsedToken->getClaims();
            if (is_null($user)) {
                $user = new UserData();
            }
            foreach ($claims as $claim) {
                $user->set($claim->getName(), $claim->getValue());
            }
            $this->setUser($user);
        } catch (Exception $e) {
            if ($e instanceof InvalidArgumentException || $e instanceof RuntimeException) {
                throw new InvalidTokenException($e->getMessage());
            } else {
                throw $e;
            }
        }
    }

    /**
     * @param IUserData $data
     * @param $exp
     * @param $nbf
     */
    public function generate(IUserData $data, $exp = 3600, $nbf = 0): string
    {
        $builder = new Builder();
        $signkey = $this->keychain->getPrivateKey("file://{$this->getPrivateKey()}", $this->passphrase);
        if ($this->iss) {
            $builder->setIssuer($this->iss);
        }
        $builder->setExpiration(time() + $exp);
        $builder->setNotBefore(time() + $nbf);
        $builder->setIssuedAt(time());
        foreach ($data->getAttributes() as $key => $value) {
            $builder->set($key, $value);
        }
        $builder->sign($this->signer, $signkey);
        $token = $builder->getToken();
        return (string) $token;
    }

    /**
     * @return mixed
     */
    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    /**
     * @return mixed
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * @return mixed
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getUser(): IUserData
    {
        if ($this->user instanceof IUserData) {
            return $this->user;
        }
        return new UserData();
    }

    /**
     * @param $priv
     */
    public function setPrivateKey(string $privateKey): void
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param $publicKey
     */
    public function setPublicKey(string $publicKey): void
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @param IUserData $user
     */
    public function setUser(IUserData $user): void
    {
        $this->user = $user;
    }

    /**
     * @param  $token
     * @return mixed
     */
    public function withToken(string $token): IAuthentication
    {
        $auth = clone $this;
        $auth->setToken($token);
        return $auth;
    }
}
