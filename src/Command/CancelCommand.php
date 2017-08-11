<?php
/**
 * Create by lurrpis
 * Date 11/08/2017 4:14 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CancelCommand extends BaseCommand
{
    public static $name = 'cancel';
    public static $side = [
        'sell',
        'buy',
        'all'
    ];

    protected function configure()
    {
        $this->setName(static::$name)
            ->addOption('side', 's', InputOption::VALUE_OPTIONAL, implode(' / ', self::$side), null)
            ->addOption('id', 'd', InputOption::VALUE_OPTIONAL, '单号', null)->setDescription('Cancel order');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('id')) {
            $cancel = Yunbi::deleteOrder($input->getOption('id'));

            if (!empty($cancel)) {
                $message = [
                    '取消挂单成功' => static::getCoin($cancel['market']),
                    '取消挂单数'  => 1,
                    '单号'     => $cancel['id'],
                    '总价'     => $cancel['avg_price'],
                    '数量'     => $cancel['remaining_volume'],
                    '时间'     => date('Y-m-d H:i:s', strtotime($cancel['created_at']))
                ];

                static::display($output, $message);
            } else {
                static::warn($output, '取消挂单失败, 请重试!');
            }
        } else if ($input->getOption('side')) {
            $side = strtolower($input->getOption('side'));

            if (!in_array($side, self::$side)) {
                static::message($output, 'Side 请在 ' . implode(' / ', self::$side) . ' 中选择');
            }

            $side == 'all' && $side = '';

            $cancel = Yunbi::clearOrders($side);


            print_r($cancel);
            exit;

            if (!empty($cancel)) {
                $message = [
                    '成功取消挂单数' => count($cancel),
                    '取消挂单总额'  => date('Y-m-d H:i:s', strtotime($cancel['created_at']))
                ];

                static::display($output, $message);
            } else {
                static::warn($output, '取消挂单失败, 请重试!');
            }
        }
    }
}