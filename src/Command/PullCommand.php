<?php
/**
 * Create by lurrpis
 * Date 12/08/2017 10:24 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PullCommand extends BaseCommand
{
    public static $name = 'pull';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, "Select a market. Default is " . self::$defaultCoin, self::$defaultCoin)
            ->addOption('start', 's', InputOption::VALUE_REQUIRED, '开始价', null)
            ->addOption('price', 'p', InputOption::VALUE_REQUIRED, '价格粒度', null)
            ->addOption('coin', 'c', InputOption::VALUE_REQUIRED, '币粒度', null)
            ->addOption('volume', 'o', InputOption::VALUE_REQUIRED, '数量', null)
            ->setDescription('Pull coin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $market = static::getMarket($input->getArgument('market'));
        $token = static::getCoin($market);

        $start = $input->getOption('start');
        $price = $input->getOption('price');
        $coin = $input->getOption('coin');
        $volume = $input->getOption('volume');

//        $orders = [];
//        $order = [
//            'side'     => 'buy',
//            'volume'   => '0.01',
//            'price'    => '0.01',
//            'ord_type' => 'limit'
//        ];
//
//        for ($i = 1; $i <= 5; $i ++) {
//            $order['volume'] += 0.01;
//            $order['price'] += 0.02;
//            array_push($orders, $order);
//        }

        $orders = [
            [
                'side'     => 'buy',
                'volume'   => 0.02,
                'price'    => 0.02,
                'ord_type' => 'limit'
            ],
            [
                'side'     => 'buy',
                'volume'   => 0.01,
                'price'    => 0.01,
                'ord_type' => 'limit'
            ],
        ];

        $pull = Yunbi::createOrderMulti($market, $orders);

        print_r($pull);exit;

        $pull = Yunbi::createOrder($market, 'sell', $coin, $price, 'limit');

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