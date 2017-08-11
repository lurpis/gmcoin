<?php
/**
 * Create by lurrpis
 * Date 11/05/2017 10:30 AM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use GMCloud\SDK\Yunbi;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NowCommand extends BaseCommand
{
    public static $name = 'now';

    protected function configure()
    {
        $this->setName(static::$name)
            ->addArgument('market', InputArgument::OPTIONAL, 'Select a market. Default is ' . self::$defaultCoin, self::$defaultCoin)
            ->setDescription('Markets now the price');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $market = static::getMarket($input->getArgument('market'));

        $line = Yunbi::tickers($market);

        $table = new Table($output);

        $header = ['币种', '买单', '卖单', '最低', '最高', '价格', '成交量', '时间'];

        $ticker = $line['ticker'];
        $row = [
            static::getCoin($market),
            $ticker['buy'],
            $ticker['sell'],
            $ticker['low'],
            $ticker['high'],
            $ticker['last'],
            number_format($ticker['vol'] / 1000, 1) . 'k',
            date('Y-m-d H:i:s', $line['at']),
        ];

        $table->setHeaders($header);
        $table->addRow($row);

        $table->render();
    }
}