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
use Symfony\Component\Console\Style\SymfonyStyle;

class PushCommand extends BaseCommand
{
    public static $name = 'push';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, "Select a market. Default is " . self::$defaultCoin,
                self::$defaultCoin)->addOption('start', 's', InputOption::VALUE_REQUIRED, '开始价格', null)
            ->addOption('price', 'p', InputOption::VALUE_REQUIRED, '每单递增价格', null)
            ->addOption('coin', 'c', InputOption::VALUE_REQUIRED, '每单代币数', null)
            ->addOption('much', 'm', InputOption::VALUE_REQUIRED, '数量', null)->setDescription('Push coin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $market = static::getMarket($input->getArgument('market'));
        $token = static::getCoin($market);

        $start = $input->getOption('start');
        $price = $input->getOption('price');
        $coin = $input->getOption('coin');
        $much = $input->getOption('much');

        $order = [
            'side'   => 'buy',
            'volume' => $coin,
            'price'  => $start
        ];

        $orders = [$order];
        for ($i = 1; $i < $much; $i ++) {
            $order['price'] += $price;

            array_push($orders, $order);
        }

        $totalPrice = 0;
        $totalCoin = 0;
        foreach ($orders as $order) {
            $totalPrice += $order['price'] * $order['volume'];
            $totalCoin += $order['volume'];
        }

        $message = [
            "币种: $token",
            " 开始价格: $start 元",
            " 每单递增价格: $price 元",
            " 每单代币数: $coin 个",
            " 挂单数量: " . count($orders) . " 单",
            " 挂单总价: $totalPrice 元",
            " 代币总数: $totalCoin 个",
            ' 已确认参数填写无误, 开始挂砸盘?'
        ];

        $confirm = $io->confirm(implode("\n", $message), true);

        if ($confirm) {
            $push = Yunbi::createOrderMulti($market, $orders);

            static::header($output);
            if (!empty($push)) {
                $id = [];
                $totalPrice = 0;
                $totalCoin = 0;
                foreach ($push as $item) {
                    array_push($id, $item['id']);
                    $totalPrice += $item['price'] * $item['volume'];
                    $totalCoin += $item['volume'];
                }

                $message = [
                    '成功挂单数' => count($push),
                    '单号'    => implode(', ', $id),
                    '挂单总价'  => $totalPrice,
                    '代币总数'  => $totalCoin,
                ];

                static::display($output, $message);
            } else {
                $output->writeln("$token <error>砸盘挂单失败, 请重试!</error>");
            }
        }
    }
}