<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\JsonQueryWrapper;

use JsonQueryWrapper\JsonQueryFactory;

/**
 * Class JsonQueryFactoryTest.
 */
class JsonQueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \JsonQueryWrapper\Exception\DataProviderMissingException
     */
    public function testCreate()
    {
        $jq = JsonQueryFactory::create();

        $this->assertInstanceOf('JsonQueryWrapper\JsonQuery', $jq);

        $jq->run('boom');
    }

    public function testCreateWith()
    {
        $jq = JsonQueryFactory::createWith(json_encode(['Foo' => ['Bar' => 33]]));
        $this->assertInstanceOf('JsonQueryWrapper\JsonQuery', $jq);
    }
}
