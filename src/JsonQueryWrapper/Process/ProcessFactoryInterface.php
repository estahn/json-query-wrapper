<?php

namespace JsonQueryWrapper\Process;

use Symfony\Component\Process\Process;

interface ProcessFactoryInterface
{
    public function build($command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60): Process;
}
