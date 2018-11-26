<?php

namespace Viloveul\Auth;

use Viloveul\Auth\Contracts\DataValue as IDataValue;

class DataValue implements IDataValue
{
    /**
     * @var array
     */
    protected $attributes = [];

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
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->values)) {
                $this->attributes[$key] = $value;
            }
        }
    }
}
