<?php

namespace Spatie\MixedContentScannerCli\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MixedContentScannerTest extends TestCase
{
    use MatchesSnapshots;

    protected $logFile = __DIR__ . '/temp/log.txt';

    public function setUp()
    {
        Server::boot();

        $this->createLogFile();
    }

    /** @test */
    public function it_can_find_mixed_content()
    {
        exec("./mixed-content-scanner scan http://" . Server::getServerUrl() . " > {$this->logFile}");

        $this->assertMatchesSnapshot(file_get_contents($this->logFile));
    }

    protected function createLogFile()
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }

        touch($this->logFile);
    }
}
