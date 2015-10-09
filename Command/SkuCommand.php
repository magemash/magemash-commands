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
class SkuCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:sku')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = \Mage::getResourceModel('catalog/product_collection')
        ->addAttributeToSelect('*');

        foreach ($products as $p) {

            $zeros = 6 - strlen($p->getId());
            $newSku = "";
            for ($i=1; $i < $zeros; $i++) {
                $newSku .= "0";
            }

            $newSku .= (string)$p->getId();

            echo $newSku."\n";

            $p->setSku($newSku);
            $p->save();
        }

        $output->writeln('<info>Sku Command</info>');
    }

}
