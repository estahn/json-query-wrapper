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
use JsonQueryWrapper\Process\ProcessFactoryInterface;

/**
 * Class JsonQuery.
 */
class JsonQuery
{
    /**
     * @var ProcessFactoryInterface
     */
    protected $processFactory;

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
     * @param ProcessFactoryInterface $processFactory
     * @param DataTypeMapper $dataTypeMapper
     */
    public function __construct(ProcessFactoryInterface $processFactory, DataTypeMapper $dataTypeMapper)
    {
        $this->processFactory = $processFactory;
        $this->mapper = $dataTypeMapper;
    }

    /**
     * Runs the command-line and returns.
     *
     * @param string $filter
     *
     * @return mixed
     * @throws DataProviderMissingException
     * @throws Exception\DataTypeMapperException
     */
    public function run($filter)
    {
        if (!$this->dataProvider instanceof DataProviderInterface) {
            throw new DataProviderMissingException('A data provider such as file or text is missing.');
        }

        $command = [$this->cmd, '-M', $filter, $this->dataProvider->getPath()];

        $process = $this->processFactory->build($command);

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
