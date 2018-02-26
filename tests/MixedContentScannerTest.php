<?php

namespace Spatie\MixedContentScannerCli\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MixedContentScannerTest extends TestCase
{
    use MatchesSnapshots;

    protected $logFile = __DIR__.'/temp/log.txt';

    public function setUp()
    {
        Server::boot();

        $this->createLogFile();
    }

    /** @test */
    public function it_can_find_mixed_content()
    {
        exec('./mixed-content-scanner scan http://'.Server::getServerUrl()." > {$this->logFile}");

        $this->assertMatchesSnapshot(file_get_contents($this->logFile));
    }

    /** @test */
    public function it_will_not_verify_ssl_by_default()
    {
        exec("./mixed-content-scanner scan https://self-signed.badssl.com/ > {$this->logFile}");

        $this->assertLogContains('Found 1 pages without mixed content');
    }

    /** @test */
    public function it_has_an_option_to_enable_ssl_verification()
    {
        exec("./mixed-content-scanner scan --verify-ssl https://self-signed.badssl.com/ > {$this->logFile}");

        $this->assertLogContains('Found 1 non responsive url(');
    }

    /** @test */
    public function it_can_ignore_links_with_the_ignore_option()
    {
        exec('./mixed-content-scanner scan http://'.Server::getServerUrl()."/ignore --ignore=replytocom > {$this->logFile}");

        $this->assertMatchesSnapshot(file_get_contents($this->logFile));
    }

    protected function createLogFile()
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }

        touch($this->logFile);
    }

    public function assertLogContains($expectedString)
    {
        $logContents = file_get_contents($this->logFile);

        $this->assertContains($expectedString, file_get_contents($this->logFile), "Failed asserting that `{$logContents}` contains the expected string `{$expectedString}`");
    }
}
