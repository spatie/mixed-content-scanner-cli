<?php

namespace Spatie\MixedContentScannerCli;

use Spatie\MixedContentScanner\MixedContentObserver;

class MixedContentLogger extends MixedContentObserver
{
    public function __construct(OutputInterface $output)
    {

    }

    public function didNotRespond(Url $crawledUrl)
    {

    }

    public function mixedContentFound(MixedContent $mixedContent)
    {

    }

    public function noMixedContentFound(Url $crawledUrl)
    {

    }
}