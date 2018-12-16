<?php

namespace Viloveul\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use Viloveul\Auth\Contracts\Authorization as IAuthorization;
use Viloveul\Auth\Contracts\UserData as IUserData;
use Viloveul\Auth\InvalidTokenException;

class Authorization implements IAuthorization
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
    protected $privateKey;

    /**
     * @var mixed
     */
    protected $publicKey;

    /**
     * @var mixed
     */
    protected $signer;

    /**
     * @var mixed
     */
    protected $token;

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
     * @return mixed
     */
    public function authenticate()
    {
        $parser = new Parser();
        $data = new ValidationData();
        try {
            $parsedToken = $parser->parse($this->getToken());
            $key = $this->keychain->getPublicKey("file://{$this->getPublicKey()}", $this->passphrase);
            if (true === $parsedToken->verify($this->signer, $key) && true === $parsedToken->validate($data)) {
                return $parsedToken->getClaims();
            }
        } catch (Exception $e) {
            if ($e instanceof InvalidArgumentException || $e instanceof RuntimeException) {
                throw new InvalidTokenException('Invalid token.');
            } else {
                throw $e;
            }
        }
        return false;
    }

    /**
     * @param IUserData $data
     * @param $exp
     * @param $nbf
     */
    public function generate(IUserData $data, $exp = 3600, $nbf = 0)
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
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return mixed
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param $priv
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @param $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
}
