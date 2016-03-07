<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonQueryWrapper\DataProvider;

/**
 * Interface DataProviderInterface.
 */
interface DataProviderInterface
{
    /**
     * Returns a file path.
     *
     * @return string
     */
    public function getPath();
}
