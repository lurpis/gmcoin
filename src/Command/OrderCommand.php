<?php
/**
 * Create by lurrpis
 * Date 11/08/2017 2:34 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrderCommand extends BaseCommand
{
    public static $name = 'order';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, 'Select a market. Default is ' . self::$defaultCoin,
                self::$defaultCoin)->addOption('id', 'd', InputOption::VALUE_OPTIONAL, '单号', null)
            ->setDescription('My orders & detail');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $market = static::getMarket($input->getArgument('market'));

        $header = ['单号', '交易', '单价', '余量', '总量', '成交', '总价', '状态', '成交数', '币种', '时间'];

        if ($input->getOption('id')) {
            $order = Yunbi::order($input->getOption('id'));

            $table = new Table($output);
            $row = self::formatRow($order);
            $table->setHeaders($header);
            $table->addRow($row);

            $table->render();

            if (!empty($order['trades'])) {
                $trades = $order['trades'];
                $table = new Table($output);
                $header = array_keys(current($trades));

                $row = [];
                foreach ($trades as $trade) {
                    array_push($row, array_values($trade));
                }

                $table->setHeaders($header);
                $table->addRows($row);

                $table->render();
            }
        } else {
            $orders = Yunbi::orders($market);
            $table = new Table($output);

            $row = [];
            foreach ($orders as $order) {
                array_push($row, static::formatRow($order));
            }

            $table->setHeaders($header);
            $table->addRows($row);

            $table->render();
        }
    }

    protected static function formatRow($order)
    {
        return [
            $order['id'],
            $order['side'] == 'buy' ? '买入' : '卖出',
            $order['price'],
            $order['remaining_volume'],
            $order['volume'],
            $order['price'] * ($order['volume'] - $order['remaining_volume']),
            $order['price'] * $order['volume'],
            $order['state'],
            $order['trades_count'],
            static::getCoin($order['market']),
            date('Y-m-d H:i:s', strtotime($order['created_at']))
        ];
    }
}