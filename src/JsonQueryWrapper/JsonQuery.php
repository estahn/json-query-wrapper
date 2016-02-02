<?php
/**
 * JSON Query Wrapper
 *
 * (The MIT license)
 * Copyright (c) 2016 Enrico Stahn
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated * documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package JsonQueryWrapper
 * @link    http://github.com/estahn/json-query-wrapper for the canonical source repository
 */

namespace JsonQueryWrapper;

use JsonQueryWrapper\DataProvider\DataProviderInterface;
use JsonQueryWrapper\Exception\DataProviderMissingException;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class JsonQuery
 *
 * @package JsonQueryWrapper
 */
class JsonQuery
{
    /**
     * @var ProcessBuilder
     */
    protected $builder;

    /**
     * @var DataTypeMapper
     */
    protected $mapper;

    /**
     * @var DataProviderInterface
     */
    protected $dataProvider;

    /**
     * Path to the jq command
     *
     * @var string
     */
    protected $cmd = 'jq';

    /**
     * JsonQuery constructor.
     *
     * @param ProcessBuilder $builder
     * @param DataTypeMapper $dataTypeMapper
     */
    public function __construct(ProcessBuilder $builder, DataTypeMapper $dataTypeMapper)
    {
        $this->builder = $builder;
        $this->mapper = $dataTypeMapper;
    }

    /**
     * Set the path to the jq command
     *
     * @param string $cmd
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Runs the command-line and returns
     *
     * @param string $filter
     * @return mixed
     * @throws DataProviderMissingException
     */
    public function run($filter)
    {
        if (!$this->dataProvider instanceof DataProviderInterface) {
            throw new DataProviderMissingException('A data provider such as file or text is missing.');
        }

        $builder = $this->builder->create();
        $builder->setPrefix($this->cmd)
            ->add($filter)
            ->add($this->dataProvider->getPath());

        $process = $builder->getProcess();
        $process->run();

        $result = trim($process->getOutput());

        return $this->mapper->map($result);
    }

    /**
     * @param DataProviderInterface $provider
     */
    public function setDataProvider(DataProviderInterface $provider)
    {
        $this->dataProvider = $provider;
    }
}
