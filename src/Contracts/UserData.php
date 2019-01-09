<?php

namespace Viloveul\Auth\Contracts;

interface UserData
{
    public function getAttributes(): array;

    /**
     * @param array $maps
     */
    public function remap(array $maps): void;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void;
}
