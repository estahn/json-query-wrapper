<?php

namespace JsonQueryWrapper\CommandLineOption;

interface CommandLineOptionInterface
{
    const OPTION_EXIT_BASED_ON_OUTPUT = 'e';
    const OPTION_INPUT_RAW = 'R';
    const OPTION_NULL_INPUT = 'n';
    const OPTION_OUTPUT_COLORIZE = 'C';
    const OPTION_OUTPUT_COMPACT = 'c';
    const OPTION_OUTPUT_JOIN = 'j';
    const OPTION_OUTPUT_MONOCHROME = 'M';
    const OPTION_OUTPUT_RAW = 'r';
    const OPTION_OUTPUT_SORT_KEYS = 'S';

    public function addOption(string $option): void;
    public static function isValidOption(string $option): bool;
    public function getOptionsAsString(): ?string;
    public function removeOption(string $option): void;
}