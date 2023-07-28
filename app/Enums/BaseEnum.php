<?php

namespace App\Enums;

abstract class BaseEnum
{
    protected static $constants = [];

    /**
     * Get all the constants defined in the enum.
     *
     * @return array
     */
    public static function all(): array
    {
        return static::$constants;
    }

    /**
     * Check if a given value exists in the enum.
     *
     * @param mixed $value
     * @return bool
     */
    public static function isValid($value): bool
    {
        return in_array($value, static::$constants);
    }

    /**
     * Get the value of the enum constant by name.
     *
     * @param string $name
     * @return mixed|null The value of the constant if found, otherwise null.
     */
    public static function getValue(string $name)
    {
        if (isset(static::$constants[$name])) {
            return static::$constants[$name];
        }

        return null;
    }
    /**
     * Get the constant name by its value.
     *
     * @param mixed $value
     * @return string|null The name of the constant if found, otherwise null.
     */
    public static function getKeyByValue($value): ?string
    {
        $key = array_search($value, static::$constants, true);

        return ($key !== false) ? $key : null;
    }

}
