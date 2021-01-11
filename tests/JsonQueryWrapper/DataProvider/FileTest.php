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
 * Class FileTest.
 */
class FileTest extends TestCase
{
    public function testGetPath()
    {
        $data = 'FooBar';
        $filename = tempnam(sys_get_temp_dir(), 'jq');
        file_put_contents($filename, $data);
        $provider = new File($filename);

        $this->assertFileExists($provider->getPath());
        $this->assertEquals($data, file_get_contents($provider->getPath()));
    }
}
