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

use JsonQueryWrapper\DataProvider\Text;
use PHPUnit\Framework\TestCase;
use JsonQueryWrapper\Process\ProcessFactoryInterface;
use Symfony\Component\Process\Process;


/**
 * Class JsonQuery.
 */
class JsonQueryTest extends TestCase
{
    public function testCmdChange()
    {
        $expected = 'Arthur';
        $json = ['id' => 1, 'name' => $expected, 'age' => 21];
        $dataProvider = new Text(json_encode($json));

        $process = $this->createMock(Process::class);
        $process
            ->method('run');

        $process
            ->method('getOutput')
            ->willReturn($expected);

        $processFactory = $this->createMock(ProcessFactoryInterface::class);
        $processFactory
            ->method('build')
            ->willReturn($process);

        $mapper = new DataTypeMapper();

        $sut = new JsonQuery(
            $processFactory,
            $mapper
        );

        $sut->setDataProvider($dataProvider);
        static::assertEquals(
            $expected,
            $sut->run('.name')
        );
    }
}
