<?php

/*
 * This file is part of the json-query-wrapper package.
 *
 * (c) Enrico Stahn <enrico.stahn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tests\JsonQueryWrapper\DataProvider;

use JsonQueryWrapper\DataProvider\Text;

/**
 * Class TextTest.
 */
class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testGetPath()
    {
        $data = 'FooBar';
        $provider = new Text($data);

        $this->assertFileExists($provider->getPath());
        $this->assertEquals($data, file_get_contents($provider->getPath()));
    }
}
