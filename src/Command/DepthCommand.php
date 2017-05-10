<?php
/**
 * Create by lurrpis
 * Date 09/05/2017 7:55 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DepthCommand extends BaseCommand
{
    public static $name = 'depth';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, 'Select a market. Default is 1ST', '1stcny')
            ->setDescription('Markets depth');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = [
            'market' => $input->getArgument('market')
        ];

        print_r(Yunbi::depth($params));
    }
}