<?php

namespace Viloveul\Auth\Contracts;

interface DataValue
{
    public function getAttributes(): array;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);
}
