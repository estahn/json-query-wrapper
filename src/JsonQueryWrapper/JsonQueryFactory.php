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

use JsonQueryWrapper\DataProvider\File;
use JsonQueryWrapper\DataProvider\Text;
use Symfony\Component\Process\ProcessBuilder;

class JsonQueryFactory
{
    /**
     * Creates a JsonQuery object without data provider.
     *
     * @return JsonQuery
     */
    public static function create()
    {
        return new JsonQuery(new ProcessBuilder(), new DataTypeMapper());
    }

    /**
     * Creates a JsonQuery object with data provider.
     *
     * @param string $filenameOrText A path to a json file or json text
     *
     * @return JsonQuery
     */
    public static function createWith($filenameOrText)
    {
        $provider = file_exists($filenameOrText) ? new File($filenameOrText) : new Text($filenameOrText);

        $jq = new JsonQuery(new ProcessBuilder(), new DataTypeMapper());
        $jq->setDataProvider($provider);

        return $jq;
    }
}
