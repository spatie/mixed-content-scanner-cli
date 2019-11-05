<?php

namespace Spatie\MixedContentScannerCli;

use GuzzleHttp\RequestOptions;
use Spatie\Crawler\Crawler;
use Spatie\MixedContentScanner\MixedContentScanner;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
            ->addOption('ignore-robots', null, InputOption::VALUE_NONE, 'Ignore robots.txt, robots meta tags and -headers.')
            ->addOption('verify-ssl', null, InputOption::VALUE_NONE, 'Verify the craweld urls have a valid certificate. If they do not an empty response will be the result of the crawl')
            ->addOption('user-agent', null, InputOption::VALUE_REQUIRED, 'User agent string to use for requests');
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

        $ignoreRobots = $input->getOption('ignore-robots');
        $userAgent = $input->getOption('user-agent');

        (new MixedContentScanner($mixedContentLogger))
            ->configureCrawler(function (Crawler $crawler) use ($ignoreRobots, $userAgent) {
                if ($ignoreRobots) {
                    $crawler->ignoreRobots();
                }
                if ($userAgent) {
                    $crawler->setUserAgent($userAgent);
                }
            })
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
