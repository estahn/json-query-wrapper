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
use JsonQueryWrapper\CommandLineOption\CommandLineOptionInterface;
use JsonQueryWrapper\DataProvider\DataProviderInterface;
use JsonQueryWrapper\Exception\DataProviderMissingException;
use JsonQueryWrapper\Exception\DataTypeMapperException;
use JsonQueryWrapper\Process\ProcessFactoryInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class JsonQuery.
 */
class JsonQuery
{
    /**
     * @var CommandLineOptionInterface
     */
    protected $commandLineOption;

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
     * @param CommandLineOptionInterface|null $commandLineOption
     */
    public function __construct(ProcessFactoryInterface $processFactory, DataTypeMapper $dataTypeMapper, ?CommandLineOptionInterface $commandLineOption = null)
    {
        $this->processFactory = $processFactory;
        $this->mapper = $dataTypeMapper;
        if ($commandLineOption) {
            $this->commandLineOption = $commandLineOption;
        } else {
            $this->commandLineOption = new CommandLineOption([CommandLineOptionInterface::OPTION_OUTPUT_MONOCHROME]);
        }
    }

    /**
     * Runs the command-line and returns.
     *
     * @param string $filter
     *
     * @return mixed
     * @throws DataProviderMissingException|\RuntimeException
     */
    public function run($filter)
    {
        if (!$this->dataProvider instanceof DataProviderInterface) {
            throw new DataProviderMissingException('A data provider such as file or text is missing.');
        }

        $options = $this->commandLineOption->getOptionsAsString();
        if ($options !== null) {
            $command = [$this->cmd, $options, $filter, $this->dataProvider->getPath()];
        } else {
            $command = [$this->cmd, $filter, $this->dataProvider->getPath()];
        }

        try {
            $process = $this->processFactory->build($command);
            $process->mustRun();
            $result = trim($process->getOutput());
            return $this->mapper->map($result);
        } catch (ProcessFailedException $processFailedException) {
            throw new \RuntimeException(trim($process->getErrorOutput()), $processFailedException->getProcess()->getExitCode(), $processFailedException);
        } catch (DataTypeMapperException $dataTypeMapperException) {
            throw new \RuntimeException($dataTypeMapperException->getMessage(), $dataTypeMapperException->getCode(), $dataTypeMapperException);
        }
    }

    /**
     * @param DataProviderInterface $provider
     */
    public function setDataProvider(DataProviderInterface $provider)
    {
        $this->dataProvider = $provider;
    }
}
