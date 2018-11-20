<?php

namespace Viloveul\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Viloveul\Auth\Contracts\Token as IToken;
use Viloveul\Auth\Contracts\Value as IValue;

class Token implements IToken
{
    /**
     * @var mixed
     */
    protected $issuer = null;

    /**
     * @var mixed
     */
    protected $passphrase = null;

    /**
     * @var mixed
     */
    protected $privateKey = null;

    /**
     * @var mixed
     */
    protected $publicKey = null;

    /**
     * @param $issuer
     * @param $passphrase
     */
    public function __construct($issuer, $passphrase = null)
    {
        $this->issuer = $issuer;
        $this->passphrase = $passphrase;
    }

    /**
     * @param $sub
     * @param $exp
     * @param $nbf
     */
    public function generate(IValue $value, $exp = 3600, $nbf = 60)
    {
        $signer = new Sha256();
        $keychain = new Keychain();
        $builder = new Builder();
        $key = $keychain->getPrivateKey("file://{$this->getPrivateKey()}", $this->passphrase);
        $builder->setIssuer($this->issuer);
        $builder->setIssuedAt(time());
        $builder->setNotBefore(time() + 60);
        $builder->setExpiration(time() + 3600);
        $builder->set('sub', $value->getAttributes());
        $builder->sign($signer, $key);
        return (string) $builder->getToken();
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
     * @param $key
     */
    public function setPrivateKey($key)
    {
        $this->privateKey = $key;
    }

    /**
     * @param $key
     */
    public function setPublicKey($key)
    {
        $this->publicKey = $key;
    }
}
