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

use JsonQueryWrapper\Exception\DataTypeMapperException;
use PHPUnit\Framework\TestCase;

/**
 * Class DataTypeMapperTest.
 */
class DataTypeMapperTest extends TestCase
{
    /**
     * @var DataTypeMapper
     */
    protected $mapper;

    protected function setUp(): void
    {
        $this->mapper = new DataTypeMapper();
    }

    public function testBoolean()
    {
        $this->assertTrue($this->mapper->map('true'));
        $this->assertFalse($this->mapper->map('false'));
    }

    public function testString()
    {
        $this->assertEquals('Foo', $this->mapper->map('"Foo"'));
        $this->assertEquals('Fo"o', $this->mapper->map('"Fo"o"'));
    }

    public function testStringWithNumber()
    {
        $value = $this->mapper->map('"33"');

        $this->assertIsString($value);
        $this->assertEquals('33', $value);
    }

    public function testInteger()
    {
        $value = $this->mapper->map('33');

        $this->assertIsInt($value);
        $this->assertEquals(33, $value);
    }

    public function testFloat()
    {
        $value = $this->mapper->map('33.02');

        $this->assertIsFloat($value);
        $this->assertEquals(33.02, $value);
    }

    public function testParserError()
    {
        $this->expectException(DataTypeMapperException::class);
        $this->mapper->map('parse error: Expected another key-value pair at line 7, column 1');
    }

    public function testNull()
    {
        $this->assertNull($this->mapper->map('null'));
    }

    public function testJson()
    {
        $this->markTestIncomplete('Need to decide whether to convert JSON data');

        $json = ['Foo' => ['Bar' => 33]];
        $this->assertEquals('Foo', $this->mapper->map(json_encode($json)));
    }

    public function testGarbage()
    {
        $this->assertEquals('2rd{,Atz"JWFv4]mZ', $this->mapper->map('2rd{,Atz"JWFv4]mZ'));
    }
}
