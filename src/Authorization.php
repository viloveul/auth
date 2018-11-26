<?php

namespace Viloveul\Auth;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Keychain;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use Viloveul\Auth\Contracts\Authorization as IAuthorization;
use Viloveul\Auth\Contracts\DataValue as IDataValue;

class Authorization implements IAuthorization
{
    /**
     * @var mixed
     */
    protected $iss = null;

    /**
     * @var mixed
     */
    protected $keychain = null;

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
     * @var mixed
     */
    protected $signer = null;

    /**
     * @param $iss
     * @param $passphrase
     */
    public function __construct($iss, $passphrase = null)
    {
        $this->signer = new Sha256();
        $this->keychain = new Keychain();
        $this->iss = $iss;
        $this->passphrase = $passphrase;
    }

    /**
     * @param $str
     * @param $callback
     */
    public function authenticate($str, callable $callback = null)
    {
        $parser = new Parser();
        $data = new ValidationData();
        $token = $parser->parse((string) $str);
        $key = $this->keychain->getPublicKey("file://{$this->getPublicKey()}", $this->passphrase);
        if (true === $token->verify($this->signer, $key) && true === $token->validate($data)) {
            if (is_callable($callback)) {
                return $callback($token->getClaims());
            }
            return $token->getClaims();
        }
        return false;
    }

    /**
     * @param $sub
     * @param $exp
     * @param $nbf
     */
    public function generate(IDataValue $value, $exp = 3600, $nbf = 60)
    {
        $builder = new Builder();
        $key = $this->keychain->getPrivateKey("file://{$this->getPrivateKey()}", $this->passphrase);
        $builder->setIssuer($this->iss);
        $builder->setIssuedAt(time());
        $builder->setNotBefore(time() + $nbf);
        $builder->setExpiration(time() + $exp);
        foreach ($value->getAttributes() as $key => $value) {
            $builder->set($key, $value);
        }
        $builder->sign($this->signer, $key);
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
