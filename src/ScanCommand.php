<?php

namespace Spatie\MixedContentScannerCli;

use GuzzleHttp\RequestOptions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputArgument;
use Spatie\MixedContentScanner\MixedContentScanner;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScanCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('scan')
            ->setDescription('Scan a site for mixed content.')
            ->addArgument('url', InputArgument::REQUIRED, 'Which argument do you want to scan')
            ->addOption('filter', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'urls whose path pass the regex will be scanned')
            ->addOption('ignore', null, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'urls whose path pass the regex will not be scanned')
            ->addOption('verify-ssl', null, InputOption::VALUE_NONE, 'Verify the craweld urls have a valid certificate. If they do not an empty response will be the result of the crawl');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scanUrl = $input->getArgument('url');

        $styledOutput = new SymfonyStyle($input, $output);

        $styledOutput->title("Start scanning {$scanUrl} for mixed content");

        $mixedContentLogger = new MixedContentLogger($styledOutput);

        $crawlProfile = new CrawlProfile(
            $input->getArgument('url'),
            $input->getOption('filter'),
            $input->getOption('ignore')
        );

        (new MixedContentScanner($mixedContentLogger))
            ->setCrawlProfile($crawlProfile)
            ->scan($scanUrl, $this->getClientOptions($input));
    }

    protected function getClientOptions(InputInterface $input): array
    {
        $httpClientOptions = [
            RequestOptions::VERIFY => false,
            RequestOptions::COOKIES => true,
            RequestOptions::CONNECT_TIMEOUT => 10,
            RequestOptions::TIMEOUT => 10,
            RequestOptions::ALLOW_REDIRECTS => false,
        ];

        if ($input->getOption('verify-ssl')) {
            $httpClientOptions[RequestOptions::VERIFY] = true;
        }

        return $httpClientOptions;
    }
}
