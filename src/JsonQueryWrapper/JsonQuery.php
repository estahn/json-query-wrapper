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

use JsonQueryWrapper\DataProvider\DataProviderInterface;
use JsonQueryWrapper\Exception\DataProviderMissingException;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class JsonQuery.
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
     * Path to the jq command.
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
     * Set the path to the jq command.
     *
     * @param string $cmd
     */
    public function setCmd($cmd)
    {
        $this->cmd = $cmd;
    }

    /**
     * Runs the command-line and returns.
     *
     * @param string $filter
     *
     * @throws DataProviderMissingException
     *
     * @return mixed
     */
    public function run($filter)
    {
        if (!$this->dataProvider instanceof DataProviderInterface) {
            throw new DataProviderMissingException('A data provider such as file or text is missing.');
        }

        $builder = $this->builder;
        $builder
            ->setPrefix($this->cmd)
            ->setArguments(['-M', $filter, $this->dataProvider->getPath()]);

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
