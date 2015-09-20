<?php

namespace MagentoCommand\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 */
class UrlCommand extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:url')
            ->addArgument('filename', InputArgument::REQUIRED, 'The filename of the csv')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Url Command</info>');
    }

}
