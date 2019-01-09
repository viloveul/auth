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
    ];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setAttributes($attributes);
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
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->values)) {
                $this->attributes[$key] = $value;
            } elseif (array_key_exists($key, $this->maps)) {
                $this->attributes[$this->maps[$key]] = $value;
            }
        }
    }
}
