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
 * Converts text (string) to be consumed by jq.
 */
class Text implements DataProviderInterface
{
    /**
     * Text data to be converted.
     *
     * @var string
     */
    protected $data;

    /**
     * Path to the generated file.
     *
     * @var string
     */
    protected $path;

    /**
     * Text constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Returns the path to the generated file.
     *
     * @return string
     */
    public function getPath()
    {
        if (empty($this->path)) {
            $this->path = tempnam(sys_get_temp_dir(), 'jq');
            file_put_contents($this->path, $this->data);
        }

        return $this->path;
    }
}
