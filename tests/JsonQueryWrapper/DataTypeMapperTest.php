<?php
/**
 * JSON Query Wrapper
 *
 * (The MIT license)
 * Copyright (c) 2016 Enrico Stahn
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated * documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package JsonQueryWrapper
 * @link    http://github.com/estahn/json-query-wrapper for the canonical source repository
 */

namespace Tests\JsonQueryWrapper;

use JsonQueryWrapper\DataTypeMapper;

/**
 * Class DataTypeMapperTest
 *
 * @package Tests\JsonQueryWrapper
 */
class DataTypeMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataTypeMapper
     */
    protected $mapper;

    public function setUp()
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

        $this->assertInternalType('string', $value);
        $this->assertEquals('33', $value);
    }

    public function testInteger()
    {
        $value = $this->mapper->map('33');

        $this->assertInternalType('int', $value);
        $this->assertEquals(33, $value);
    }

    public function testFloat()
    {
        $value = $this->mapper->map('33.02');

        $this->assertInternalType('float', $value);
        $this->assertEquals(33.02, $value);
    }

    /**
     * @expectedException \JsonQueryWrapper\Exception\DataTypeMapperException
     */
    public function testParserError()
    {
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
