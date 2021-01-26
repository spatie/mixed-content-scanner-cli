<?php

namespace Spatie\MixedContentScannerCli\Test;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class MixedContentScannerTest extends TestCase
{
    use MatchesSnapshots;

    protected $logFile = __DIR__.'/temp/log.txt';

    protected $userAgentLogFile = __DIR__.'/temp/agent.txt';

    protected function setUp()
    {
        Server::boot();

        $this->createLogFiles();
    }

    /** @test */
    public function it_can_find_mixed_content()
    {
        $this->performScan('http://'.Server::getServerUrl());

        $log = file_get_contents($this->logFile);

        $this->assertContains('http://localhost:9000/mixedContent: found mixed content', $log);
        $this->assertContains('Found 1 pieces of mixed content', $log);
    }

    /** @test */
    public function it_will_not_verify_ssl_by_default()
    {
        $this->performScan('https://self-signed.badssl.com/');

        $this->assertLogContains('Found 1 pages without mixed content');
    }

    /** @test */
    public function it_has_an_option_to_enable_ssl_verification()
    {
        $this->performScan('--verify-ssl https://self-signed.badssl.com/');

        $this->assertLogContains('Found 1 non responsive url(');
    }

    /** @test */
    public function it_can_ignore_links_with_the_ignore_option()
    {
        $this->performScan('http://'.Server::getServerUrl('ignore').' --ignore=replytocom');

        $this->assertMatchesSnapshot(file_get_contents($this->logFile));
    }

    /** @test */
    public function it_can_pass_a_custom_user_agent()
    {
        $userAgent = 'My-custom-user-agent-string';

        $this->performScan('http://'.Server::getServerUrl('userAgent')." --user-agent={$userAgent}");

        $this->assertEquals(file_get_contents($this->userAgentLogFile), $userAgent);
    }

    protected function performScan(?string $arguments = '')
    {
        exec("./mixed-content-scanner scan {$arguments} > {$this->logFile}");
    }

    protected function createLogFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);
    }

    protected function createLogFiles()
    {
        foreach ([$this->logFile, $this->userAgentLogFile] as $file) {
            $this->createLogFile($file);
        }
    }

    public function assertLogContains($expectedString)
    {
        $logContents = file_get_contents($this->logFile);

        $this->assertContains($expectedString, file_get_contents($this->logFile), "Failed asserting that `{$logContents}` contains the expected string `{$expectedString}`");
    }
}
