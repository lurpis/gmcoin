<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 3:31 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MarketCommand extends BaseCommand
{
    public static $name = 'market';

    protected function configure()
    {
        $this->setName(static::$name)->setDescription('All available markets');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        print_r(Yunbi::markets());
    }
}