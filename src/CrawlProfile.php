<?php

namespace Spatie\MixedContentScannerCli;

use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlInternalUrls;

class CrawlProfile extends CrawlInternalUrls
{
    protected $baseUrl = '';

    protected $filters = [];

    protected $ignores = [];

    public function __construct(string $baseUrl, array $filters, array $ignores)
    {
        parent::__construct($baseUrl);

        $this->filters = $filters;

        $this->ignores = $ignores;
    }

    public function shouldCrawl(UriInterface $url): bool
    {
        if (! parent::shouldCrawl($url)) {
            return false;
        }

        if ((string) $url === (string) $this->baseUrl) {
            return true;
        }

        foreach ($this->filters as $filter) {
            if (! preg_match("/{$filter}/", $url->getPath())) {
                return false;
            }
        }

        foreach ($this->ignores as $ignore) {
            if (preg_match("/{$ignore}/", $url->getPath())) {
                return false;
            }
        }

        return true;
    }
}
