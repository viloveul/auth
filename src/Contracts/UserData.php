<?php

namespace Viloveul\Auth\Contracts;

interface UserData
{
    /**
     * @param string     $name
     * @param $default
     */
    public function get(string $name, $default);

    public function getAttributes(): array;

    /**
     * @param array $maps
     */
    public function remap(array $maps): void;

    /**
     * @param string   $name
     * @param $value
     */
    public function set(string $name, $value): void;

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes): void;
}
