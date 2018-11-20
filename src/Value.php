<?php

namespace Viloveul\Auth;

use Viloveul\Auth\Contracts\Value as IValue;

class Value implements IValue
{
    /**
     * @var array
     */
    protected $attributes = [];

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
        $this->attributes = $attributes;
    }
}
