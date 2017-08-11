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
    public static $defaultCoin = 'SNT';

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

    public static function getMarket($market)
    {
        $market = strtolower($market);
        if (strpos($market, 'cny') === false) {
            $market .= 'cny';
        }

        return $market;
    }

    public static function getCoin($market)
    {
        return strtoupper(substr($market, 0, strlen($market) - 3));
    }

    public static function display(OutputInterface $output, $message)
    {
        foreach ($message as $key => $item) {
            $output->writeln('<info>' . $key . ':</info> ' . $item);
        }
    }

    public static function message(OutputInterface $output, $content)
    {
        $output->writeln('<info>' . $content . '</info>');
    }

    public static function warn(OutputInterface $output, $content)
    {
        $output->writeln('<error>' . $content . '</error>');
    }
}