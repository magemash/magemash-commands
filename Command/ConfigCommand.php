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
class ConfigCommand extends AbstractCommand
{
    protected $configModel;

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('magemash:config')
            ->setDescription('Resets configuration with with settings in /app/etc/config.php')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = array();
        require_once(\Mage::getBaseDir('etc').DS."config.php");

        $this->setConfigModel();

        ini_set("display_errors", 1);
        \Mage::app('admin')->setUseSessionInUrl(false);
        \Mage::getConfig()->init();

        foreach ($config as $key => $value) {
            switch($key) {
                case "default":
                    $this->addConfig($value);
                    break;
                case "websites":
                    foreach ($value as $k => $v) {
                        $this->addConfig($v, 'websites', $k);
                    }
                    break;
                case "stores":
                    foreach ($value as $k => $v) {
                        $this->addConfig($v, 'stores', $k);
                    }
                    break;
                default:
                    break;
            }
        }

        $output->writeln('<info>Config updated</info>');
    }

    protected function setConfigModel()
    {
        $this->configModel = new \Mage_Core_Model_Config();
    }

    protected function addConfig($items, $scope = "default", $scopeId = 0)
    {
        foreach ($items as $key => $value) {
            $this->configModel->saveConfig($key, $value, $scope, $scopeId);
        }
    }
}
