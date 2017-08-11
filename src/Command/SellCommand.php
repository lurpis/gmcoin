<?php
/**
 * Create by lurrpis
 * Date 11/08/2017 5:13 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SellCommand extends BaseCommand
{
    public static $name = 'sell';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, "Select a market. Default is " . self::$defaultCoin, self::$defaultCoin)
            ->addOption('price', 'p', InputOption::VALUE_REQUIRED, '单价', null)
            ->addOption('coin', 'c', InputOption::VALUE_REQUIRED, '数量', null)
            ->setDescription('Sell coin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $market = static::getMarket($input->getArgument('market'));
        $token = static::getCoin($market);

        $price = $input->getOption('price');
        $coin = $input->getOption('coin');

        $sell = Yunbi::createOrder($market, 'sell', $coin, $price, 'limit');

        static::header($output);
        if (!empty($sell)) {
            $message = [
                '挂单成功' => $token,
                '单号'   => $sell['id'],
                '卖价'   => $price,
                '数量'   => $coin,
                '时间'   => date('Y-m-d H:i:s', strtotime($sell['created_at']))
            ];

            static::display($output, $message);
        } else {
            $output->writeln("$token <error>挂单失败, 请重试!</error>");
        }
    }
}