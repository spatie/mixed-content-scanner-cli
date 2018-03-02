<?php

namespace Spatie\MixedContentScannerCli;

use Psr\Http\Message\UriInterface;
use GuzzleHttp\Exception\RequestException;
use Spatie\MixedContentScanner\MixedContent;
use Symfony\Component\Console\Style\SymfonyStyle;
use Spatie\MixedContentScanner\MixedContentObserver;

class MixedContentLogger extends MixedContentObserver
{
    protected $nonResponsiveUrls = [];

    protected $mixedContent = [];

    protected $urlsWithoutMixedContent = [];

    /** @var \Symfony\Component\Console\Style\SymfonyStyle */
    protected $output;

    public function __construct(SymfonyStyle $output)
    {
        $this->output = $output;
    }

    public function didNotRespond(UriInterface $crawledUrl)
    {
        $this->log("{$crawledUrl}: server did not respond when crawling", 'comment');

        $this->nonResponsiveUrls[] = $crawledUrl;
    }

    public function mixedContentFound(MixedContent $mixedContent)
    {
        $foundOnUrl = $mixedContent->foundOnUrl;
        $elementName = $mixedContent->elementName;
        $mixedContentUrl = $mixedContent->mixedContentUrl;

        $this->log(
            "{$foundOnUrl}: found mixed content on element {$elementName} with url {$mixedContentUrl}",
            'error'
        );

        $this->mixedContent[] = $mixedContent;
    }

    public function noMixedContentFound(UriInterface $url)
    {
        $this->log("{$url}: ok");

        $this->urlsWithoutMixedContent[] = $url;
    }

    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ) {
        $this->didNotRespond($url);
    }

    public function finishedCrawling()
    {
        $this->output->title('Scan results');

        if (count($this->mixedContent)) {
            $this->log('Found '.count($this->mixedContent).' pieces of mixed content', 'error');

            $mixedContentMessages = array_map(function (MixedContent $mixedContent) {
                $foundOnUrl = $mixedContent->foundOnUrl;
                $elementName = $mixedContent->elementName;
                $mixedContentUrl = $mixedContent->mixedContentUrl;

                return "{$foundOnUrl}: found mixed content on element {$elementName} with url {$mixedContentUrl}";
            }, $this->mixedContent);

            $this->output->listing($mixedContentMessages, 'error');
        }

        if (count($this->nonResponsiveUrls)) {
            $this->log('Found '.count($this->nonResponsiveUrls).' non responsive url(s)', 'comment');
            $this->output->listing($this->nonResponsiveUrls);
        }

        $this->log('Found '.count($this->urlsWithoutMixedContent).' pages without mixed content');

        $this->output->newLine(1);
    }

    protected function log($message, $level = 'info')
    {
        $this->output->writeln("<{$level}>{$message}</{$level}>");
    }
}
