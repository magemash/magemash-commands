<?php

namespace MagentoCommand\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfonyconsole\Command\AbstractCommand;

/**
 */
class UrlCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:url')
            ->setDescription('Resets all URLS to product name with dashes. Add sku with option --sku')
            ->addOption('sku', null, InputOption::VALUE_NONE, 'Append sku to url?')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = \Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku');

        foreach ($products as $p) {
            if ($input->getOption('sku')) {
                $rawUrl = $p->getName()." ".$p->getSku();
            } else {
                $rawUrl = $p->getName();
            }

            $url = \Mage::getModel('catalog/product_url')->formatUrlKey($rawUrl);

            echo $url . "\n";

            $p->setUrlKey($url);
            $p->save();
        }

        $output->writeln('<info>Url Command</info>');
    }

}
