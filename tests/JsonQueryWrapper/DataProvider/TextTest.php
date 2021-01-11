<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JsonQueryWrapper\DataProvider;

use PHPUnit\Framework\TestCase;

/**
 * Class TextTest.
 */
class TextTest extends TestCase
{
    public function testGetPath()
    {
        $data = 'FooBar';
        $provider = new Text($data);

        $this->assertFileExists($provider->getPath());
        $this->assertEquals($data, file_get_contents($provider->getPath()));
    }
}
