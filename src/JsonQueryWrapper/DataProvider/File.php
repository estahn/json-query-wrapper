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
 * Class File.
 */
class File implements DataProviderInterface
{
    /**
     * Path to the file.
     *
     * @var string
     */
    protected $file;

    /**
     * File constructor.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Returns path to the file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->file;
    }
}
