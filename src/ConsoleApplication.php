<?php

namespace Spatie\MixedContentScannerCli;

use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    public function __construct()
    {
        parent::__construct('PHPUnit Watcher', '1.0.0');

        $this->add(new ScanCommand());
    }

    public function getLongVersion()
    {
        return parent::getLongVersion().' by <comment>Spatie</comment>';
    }
}
