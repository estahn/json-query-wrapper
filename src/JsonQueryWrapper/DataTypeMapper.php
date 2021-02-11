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
        $boolean = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);
        if ($boolean !== null) {
            return $boolean;
        }

        if ($value === 'null') {
            return null;
        }

        if (is_numeric($value)) {
            return $value + 0;
        }

        // Map parser error
        if (preg_match('/^parse error: (.*)$/', $value, $matches)) {
            throw new DataTypeMapperException($matches[1]);
        }

        // Map strings
        if (preg_match('/^"(.*)"$/', $value, $matches)) {
            return $matches[1];
        }

        $data = json_decode($value);
        if ($data !== null) {
            return $data;
        }
        return $value;
    }
}
