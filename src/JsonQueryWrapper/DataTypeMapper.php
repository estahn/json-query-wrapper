<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonQueryWrapper;

use JsonQueryWrapper\Exception\DataTypeMapperException;

/**
 * Map data returned from jq to PHP data types.
 */
class DataTypeMapper
{
    /**
     * Returns a PHP typed value.
     *
     * @param string $value
     *
     * @throws DataTypeMapperException
     *
     * @return mixed
     */
    public function map($value)
    {
        if ($value === 'true') {
            return true;
        }

        if ($value === 'false') {
            return false;
        }

        if ($value === 'null') {
            return;
        }

        // Map integers
        if (preg_match('/^(\d+)$/', $value, $matches)) {
            return (int) $matches[1];
        }

        // Map floats
        if (preg_match('/^(\d+\.\d+)$/', $value, $matches)) {
            return (float) $matches[1];
        }

        // Map strings
        if (preg_match('/^"(.*)"$/', $value, $matches)) {
            return $matches[1];
        }

        // Map parser error
        if (preg_match('/^parse error: (.*)$/', $value, $matches)) {
            throw new DataTypeMapperException($matches[1]);
        }

        return $value;
    }
}
