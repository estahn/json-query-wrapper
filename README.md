# JSON Query Wrapper

[![Latest Stable Version](https://poser.pugx.org/estahn/json-query-wrapper/version.png)](https://packagist.org/packages/estahn/json-query-wrapper)
[![Total Downloads](https://poser.pugx.org/estahn/json-query-wrapper/d/total.png)](https://packagist.org/packages/estahn/json-query-wrapper)
[![Dependency Status](https://www.versioneye.com/user/projects/56af6f3c3d82b90032bff8d7/badge.svg?style=flat)](https://www.versioneye.com/user/projects/56af6f3c3d82b90032bff8d7)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/727aca9e-cd01-49b7-94f7-a26030ba5639/mini.png)](https://insight.sensiolabs.com/projects/727aca9e-cd01-49b7-94f7-a26030ba5639)
[![Build Status](https://travis-ci.org/estahn/json-query-wrapper.png?branch=master)](https://travis-ci.org/estahn/json-query-wrapper)
[![StyleCI](https://styleci.io/repos/50842755/shield)](https://styleci.io/repos/50842755)

json-query-wrapper is a wrapper for the popular command-line JSON processor "[jq](https://stedolan.github.io/jq/)".

## Features

* Easy to use interface
* PHP data type mapping

## Installation

```bash
$ composer require invoicesharing/json-query-wrapper
```

## Usage
### Basic usage
`test.json`:
```json
{
  "Foo": {
    "Bar": "33"
  }
}
```

**Example 1:**
```php
$jq = JsonQueryWrapper\JsonQueryFactory::createWith('test.json');
$jq->run('.Foo.Bar'); # string(33)
```

**Example 2:**
```php
$jq = JsonQueryWrapper\JsonQueryFactory::createWith('test.json');
$jq->run('.Foo.Bar == "33"'); # Returns bool(true)
```

**Example 3:**
```php
$jq = JsonQueryWrapper\JsonQueryFactory::createWith('{"Foo":{"Bar":"33"}}');
$jq->run('.Foo.Bar == "33"'); # Returns bool(true)
```

### Advanced usage

**Example 1:**
```php
$jq = JsonQueryWrapper\JsonQueryFactory::create();
$jq->setDataProvider(new JsonQueryWrapper\DataProvider\File('test.json');
$jq->run('.Foo.Bar == "33"'); # Returns bool(true)
```

## Data Providers

A "Data Provider" provides the wrapper with the necessary data to read from. It's a common interface for several providers. All providers implement the `DataProviderInterface` which essentially returns a path to the file for `jq`.

Available providers:

* `Text` - Regular PHP string containing JSON data
* `File` - A path to a file containing JSON data

## Badge Mania
[![Build Status](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/badges/build.png?b=master)](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/estahn/json-query-wrapper/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/95079dc568414f938388af783c9a6672)](https://www.codacy.com/app/estahn/json-query-wrapper)
[![Codacy Badge](https://api.codacy.com/project/badge/coverage/95079dc568414f938388af783c9a6672)](https://www.codacy.com/app/Codacy/php-codacy-coverage)


## Alternatives

* [jmespath.php](https://github.com/jmespath/jmespath.php) - Declaratively specify how to extract elements from a JSON document, in PHP
* [JSONPath](https://github.com/FlowCommunications/JSONPath) - JSONPath implementation for PHP (based on Stefan Goessner's JSONPath script)
