<?php

namespace Viloveul\Auth;

use Viloveul\Auth\Contracts\UserData as IUserData;

class UserData implements IUserData
{
    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var array
     */
    protected $maps = [
        'id' => 'sub',
    ];

    /**
     * @var array
     * @see http://www.iana.org/assignments/jwt/jwt.xhtml
     */
    protected $values = [
        'sub',
        'name',
        'email',
        'nickname',
        'iss',
        'exp',
        'nbf',
        'iat',
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
    }

    /**
     * @param string     $name
     * @param $default
     */
    public function get(string $name, $default = null)
    {
        if (array_key_exists($name, $this->maps)) {
            $key = $this->maps[$name];
        }
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : $default;
    }

    /**
     * @return mixed
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $maps
     */
    public function remap(array $maps): void
    {
        $this->maps = [];
        foreach ($maps as $key => $value) {
            if (in_array($value, $this->values)) {
                $this->maps[$key] = $value;
            }
        }
    }

    /**
     * @param string   $name
     * @param $value
     */
    public function set(string $name, $value = null): void
    {
        if (in_array($name, $this->values)) {
            $this->attributes[$name] = $value;
        } elseif (array_key_exists($name, $this->maps)) {
            $this->attributes[$this->maps[$name]] = $value;
        }
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            $this->set($key, $value);
        }
    }
}
