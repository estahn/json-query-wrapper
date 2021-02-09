<?php

namespace JsonQueryWrapper\CommandLineOption;

class CommandLineOption implements CommandLineOptionInterface
{
    /**
     * @param array
     */
    protected $options;

    public function __construct(array $options = [])
    {
        $this->options = [];
        foreach ($options as $option) {
            $this->addOption($option);
        }
    }

    public function addOption(string $option): void
    {
        if (!in_array($option, $this->options) && static::isValidOption($option)) {
            $this->options[] = $option;
        }
    }

    public static function isValidOption(string $option): bool
    {
        $reflector = new \ReflectionClass(CommandLineOptionInterface::class);
        $availableOptions = array_values($reflector->getConstants());
        return in_array($option, $availableOptions);
    }

    public function getOptionsAsString(): ?string
    {
        return empty($this->options) ? null : '-' . implode('', $this->options);
    }

    public function removeOption(string $option): void
    {
        $optionIndex = array_keys($this->options, $option)[0] ?? null;
        if ($optionIndex !== null) {
            unset($this->options[$optionIndex]);
            $this->options = array_values($this->options);
        }
    }
}