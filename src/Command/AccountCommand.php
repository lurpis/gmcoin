<?php
/**
 * Create by lurrpis
 * Date 04/05/2017 6:37 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\GMCoin\Client\Yunbi;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AccountCommand extends BaseCommand
{
    public static $name = 'account';

    protected function configure()
    {
        $this->setName(static::$name)->setDescription('My account');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        print_r(Yunbi::deposits());
    }
}