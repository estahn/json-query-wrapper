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

use JsonQueryWrapper\Exception\DataProviderMissingException;
use PHPUnit\Framework\TestCase;

/**
 * Class JsonQueryFactoryTest.
 */
class JsonQueryFactoryTest extends TestCase
{
    public function testCreate()
    {
        $this->expectException(DataProviderMissingException::class);

        $jq = JsonQueryFactory::create();

        $this->assertInstanceOf(JsonQuery::class, $jq);

        $jq->run('boom');
    }

    public function testCreateWith()
    {
        $jq = JsonQueryFactory::createWith(json_encode(['Foo' => ['Bar' => 33]]));
        $this->assertInstanceOf(JsonQuery::class, $jq);
    }
}
