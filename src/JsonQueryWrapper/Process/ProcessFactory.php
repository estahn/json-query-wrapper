<?php

namespace JsonQueryWrapper\Process;

use Symfony\Component\Process\Process;

class ProcessFactory implements ProcessFactoryInterface
{
    public function build($command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60): Process
    {
        return new Process($command, $cwd, $env, $input, $timeout);
    }
}
