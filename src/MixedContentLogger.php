<?php

namespace Spatie\MixedContentScannerCli;

use Spatie\Crawler\Url;
use Spatie\MixedContentScanner\MixedContent;
use Spatie\MixedContentScanner\MixedContentObserver;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MixedContentLogger extends MixedContentObserver
{
    protected $mixedContent = [];

    /** @var \Symfony\Component\Console\Style\SymfonyStyle */
    protected $output;

    public function __construct(SymfonyStyle $output)
    {
        $this->output = $output;
    }

    public function didNotRespond(Url $crawledUrl)
    {
        $this->log("Server did not respond when crawling {$crawledUrl}");
    }

    public function mixedContentFound(MixedContent $mixedContent)
    {
        $foundOnUrl = $mixedContent->foundOnUrl;
        $elementName = $mixedContent->elementName;
        $mixedContentUrl = $mixedContent->mixedContentUrl;

        $this->log(
            "{$foundOnUrl}: Found mixed content on element {$elementName} with url {$mixedContentUrl}",
            'error'
        );

        $this->mixedContent = $mixedContent;
    }

    public function noMixedContentFound(Url $url)
    {
        $this->log("{$url}: ok");
    }

    public function finishedCrawling()
    {
        $this->log('DISPLAY end result');
    }

    protected function log($message, $level = 'info')
    {
        $this->output->writeln("<{$level}>{$message}</{$level})>");
    }
}