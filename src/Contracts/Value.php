<?php

namespace Viloveul\Auth\Contracts;

interface Value
{
    public function getAttributes(): array;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);
}
