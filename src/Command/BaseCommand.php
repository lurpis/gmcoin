<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:14 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    public static $name;

    public static function header(OutputInterface $output)
    {
//        $output->writeln('<info>-------GMCoin-------</info>');
    }

    public static function segment(OutputInterface $output)
    {
        $output->writeln('<info>-------------------</info>');
    }

    public static function footer(OutputInterface $output)
    {
        $output->writeln('<info>-------------------</info>');
    }
}