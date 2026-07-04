<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

class ServeCommand extends BaseServeCommand
{
    /**
     * @return array<int, string>
     */
    protected function serverCommand(): array
    {
        $command = parent::serverCommand();
        $ini = public_path('php.ini');

        if (! file_exists($ini)) {
            return $command;
        }

        $settings = parse_ini_file($ini, false, INI_SCANNER_RAW);

        if (! is_array($settings)) {
            return $command;
        }

        $directives = [];

        foreach ($settings as $key => $value) {
            $directives[] = '-d';
            $directives[] = "{$key}={$value}";
        }

        array_splice($command, 1, 0, $directives);

        return $command;
    }
}
