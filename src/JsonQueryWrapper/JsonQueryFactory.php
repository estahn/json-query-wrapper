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

use JsonQueryWrapper\CommandLineOption\CommandLineOption;
use JsonQueryWrapper\DataProvider\File;
use JsonQueryWrapper\DataProvider\Text;
use JsonQueryWrapper\Process\ProcessFactory;

class JsonQueryFactory
{
    const DEFAULT_OPTIONS = [CommandLineOption::OPTION_OUTPUT_MONOCHROME];

    /**
     * Creates a JsonQuery object without data provider.
     *
     * @param array $options command line options
     *
     * @return JsonQuery
     */
    public static function create($options = self::DEFAULT_OPTIONS)
    {
        return new JsonQuery(new ProcessFactory(), new DataTypeMapper(), new CommandLineOption($options));
    }

    /**
     * Creates a JsonQuery object with data provider.
     *
     * @param string $filenameOrText A path to a json file or json text
     * @param array $options command line options
     *
     * @return JsonQuery
     */
    public static function createWith($filenameOrText, $options = self::DEFAULT_OPTIONS)
    {
        $provider = file_exists($filenameOrText) ? new File($filenameOrText) : new Text($filenameOrText);

        $jq = new JsonQuery(new ProcessFactory(), new DataTypeMapper(), new CommandLineOption($options));
        $jq->setDataProvider($provider);

        return $jq;
    }
}
