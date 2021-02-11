<?php

namespace JsonQueryWrapper\CommandLineOption;

use PHPUnit\Framework\TestCase;

class CommandLineOptionTest extends TestCase
{
    public function testEmptyCommandLineOptions()
    {
        $options = new CommandLineOption();
        $this->assertNull($options->getOptionsAsString());
    }

    public function testAddingCommandLineOptions()
    {
        $options = new CommandLineOption();
        $options->addOption(CommandLineOption::OPTION_OUTPUT_JOIN);
        $options->addOption(CommandLineOption::OPTION_OUTPUT_SORT_KEYS);
        $this->assertEquals($options->getOptionsAsString(), '-jS');
    }

    public function testAddingDuplicateCommandLineOptions()
    {
        $options = new CommandLineOption();
        $options->addOption(CommandLineOption::OPTION_OUTPUT_JOIN);
        $options->addOption(CommandLineOption::OPTION_OUTPUT_SORT_KEYS);
        $this->assertEquals($options->getOptionsAsString(), '-jS');
        $options->addOption(CommandLineOption::OPTION_OUTPUT_JOIN);
        $options->addOption(CommandLineOption::OPTION_OUTPUT_SORT_KEYS);
        $this->assertEquals($options->getOptionsAsString(), '-jS');
    }

    public function testRemovingCommandLineOptions()
    {
        $options = new CommandLineOption();
        $options->addOption(CommandLineOption::OPTION_OUTPUT_JOIN);
        $options->addOption(CommandLineOption::OPTION_OUTPUT_SORT_KEYS);
        $this->assertEquals($options->getOptionsAsString(), '-jS');
        $options->removeOption(CommandLineOption::OPTION_OUTPUT_SORT_KEYS);
        $this->assertEquals($options->getOptionsAsString(), '-j');
    }
}