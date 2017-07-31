<?php

namespace Spatie\MixedContentScannerCli;

use Spatie\Crawler\CrawlInternalUrls;
use Spatie\Crawler\CrawlProfile as CrawlProfileInterface;
use Spatie\Crawler\Url;

class CrawlProfile extends CrawlInternalUrls
{
    protected $baseUrl = '';

    protected $filters = [];

    protected $ignores = [];

    public function __construct(string $baseUrl, array $filters, array $ignores)
    {
        parent::__construct($baseUrl);

        $this->baseUrl = $baseUrl;

        $this->filters = $filters;

        $this->ignores = $ignores;
    }

    public function shouldCrawl(Url $url): bool
    {
        if (! parent::shouldCrawl($url)) {
            return false;
        }

        if ($url->isEqual(Url::create($this->baseUrl))) {
            return true;
        }

        foreach($this->filters as $filter) {
            if (! preg_match("/{$filter}/", $url->path)) {
                return false;
            }
        }

        foreach($this->ignores as $ignore) {
            if (preg_match("/{$ignore}/", $url->path)) {
                return false;
            }
        }

        return true;
    }
}