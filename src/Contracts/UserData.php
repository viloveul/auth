<?php

namespace Viloveul\Auth\Contracts;

interface UserData
{
    public function getAttributes(): array;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes);
}
