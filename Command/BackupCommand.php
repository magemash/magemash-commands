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
class BackupCommand extends AbstractCommand
{
    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:backup')
            ->setDescription('Create backup of DB')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $backupDbHelper = \Mage::getModel('backup/db');

            //create backup instance, set certain options
            $backup   = \Mage::getModel('backup/backup')
                ->setTime(time())
                ->setType('db')
                ->setPath(\Mage::getBaseDir("var") . DS . "backups");

            //do actual backup
            $backupDbHelper->createBackup($backup);

            //return success
            $output->writeln('<info>Backup Successfully Created</info>');

        } catch (Exception  $e) {

            //log exception magento and print to screen
            \Mage::logException($e->getMessage());
            $output->writeln('<info>Error while creating backup: ' . $e->getMessage().'</info>');
        }

        $output->writeln('<info>Backup Command</info>');
    }
}
