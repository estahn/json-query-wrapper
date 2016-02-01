# JSON Query Wrapper

[![Build Status](https://travis-ci.org/estahn/json-query-wrapper.png?branch=master)](https://travis-ci.org/estahn/json-query-wrapper)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/95079dc568414f938388af783c9a6672)](https://www.codacy.com/app/estahn/json-query-wrapper)
[![Latest Stable Version](https://poser.pugx.org/estahn/json-query-wrapper/version.png)](https://packagist.org/packages/estahn/json-query-wrapper)
[![Total Downloads](https://poser.pugx.org/estahn/json-query-wrapper/d/total.png)](https://packagist.org/packages/estahn/json-query-wrapper)

json-query-wrapper is a wrapper for the popular command-line JSON processor "[jq](https://stedolan.github.io/jq/)".

## Features

* Convenient interface
* Data Type Mapping

## Installation

## Usage

``
$jq = JsonQueryWrapper\JsonQueryFactory::create();
$jq->filter('.Foo.Bar');
``