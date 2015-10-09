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
class VisCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:vis')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configurables = \Mage::getResourceModel('catalog/product_collection')
            ->clear()
            ->addAttributeToFilter('type_id', 'configurable')
            ->load();

        foreach ($configurables as $c) {

            $products = $c->getTypeInstance()
                ->getUsedProductCollection(null,$c)
                ->addAttributeToSelect('visibility');

            foreach ($products as $p) {

                echo $p->getId()."\n";
                $p->setVisibility(\Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE);

                echo $p->getVisibility();
                $p->save();
            }
        }

        $output->writeln('<info>Vis Command</info>');
    }
}
