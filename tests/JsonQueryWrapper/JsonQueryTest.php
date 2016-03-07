<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\JsonQueryWrapper;

use JsonQueryWrapper\DataProvider\Text;
use JsonQueryWrapper\DataTypeMapper;
use JsonQueryWrapper\JsonQuery;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class JsonQuery.
 */
class JsonQueryTest extends \PHPUnit_Framework_TestCase
{
    public function testCmdChange()
    {
        $this->markTestSkipped('WIP');

        $builder = new ProcessBuilder();

        $builder = $this
            ->getMockBuilder('Symfony\Component\Process\ProcessBuilder')
            ->disableOriginalConstructor()
            ->getMock()
            ->method('setPrefix')->with('foobar')->will($this->returnSelf());

        $test = json_encode(['Foo' => ['Bar' => 33]]);

        $jq = new JsonQuery($builder, new DataTypeMapper());
        $jq->setCmd('foobar');

        $this->assertTrue($jq->run('.Foo.Bar == 33'));
    }

    public function testSomething()
    {
        $this->markTestSkipped('WIP');

        $test = json_encode(['Foo' => ['Bar' => 33]]);

        $jq = new JsonQuery(new ProcessBuilder(), new DataTypeMapper());
        $jq->setCmd('foobar');
        $jq->setDataProvider(new Text($test));

        $this->assertTrue($jq->run('.Foo.Bar == 33'));
    }

    public function testFixProcessBuilderPileup()
    {
        $process1 = $this->getMockBuilder('Symfony\Component\Process\Process')
            ->disableOriginalConstructor()
            ->getMock();
        $process1->expects($this->once())->method('run');
        $process1->expects($this->once())->method('getOutput')->will($this->returnValue(33));

        $process2 = $this->getMockBuilder('Symfony\Component\Process\Process')
            ->disableOriginalConstructor()
            ->getMock();
        $process2->expects($this->once())->method('run');
        $process2->expects($this->once())->method('getOutput')->will($this->returnValue(33));

        $processBuilder = $this->getMockBuilder('Symfony\Component\Process\ProcessBuilder')
            ->disableOriginalConstructor()
            ->getMock();
        $processBuilder->expects($this->any())->method('setPrefix')->will($this->returnSelf());
        $processBuilder->expects($this->any())->method('setArguments')->will($this->returnSelf());
        $processBuilder->expects($this->any())->method('getProcess')
                ->will($this->onConsecutiveCalls($process1, $process2));

        $dataTypeMapper = $this->getMockBuilder('JsonQueryWrapper\DataTypeMapper')
            ->disableOriginalConstructor()
            ->getMock();
        $dataTypeMapper->expects($this->any())->method('map')->will($this->onConsecutiveCalls(33, 33));

        $provider = $this->getMockBuilder('JsonQueryWrapper\DataProvider\Text')
            ->disableOriginalConstructor()
            ->getMock();

        $jsonQuery = new JsonQuery($processBuilder, $dataTypeMapper);
        $jsonQuery->setDataProvider($provider);

        $this->assertEquals(33, $jsonQuery->run('.Foo.Bar'));
        $this->assertEquals(33, $jsonQuery->run('.Foo.Bar'));
    }
}
