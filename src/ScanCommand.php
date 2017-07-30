<?php

namespace Spatie\MixedContentScannerCli;

use Symfony\Component\Console\Command\Command;
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
            ->addArgument('url', InputArgument::REQUIRED, 'Which argument do you want to scan');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scanUrl = $input->getArgument('url');

        $styledOutput = new SymfonyStyle($input, $output);

        $styledOutput->title("Start scanning {$scanUrl} for mixed content");

        $mixedContentLogger = new MixedContentLogger($styledOutput);

        (new MixedContentScanner($mixedContentLogger))
            ->scan($input->getArgument('url'));
    }
}
