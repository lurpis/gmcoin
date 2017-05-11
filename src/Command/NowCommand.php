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
            ->addArgument('market', InputArgument::OPTIONAL, 'Select a market. Default is 1ST', '1stcny')
            ->setDescription('Markets now the price');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $line = Yunbi::tickers($input->getArgument('market'));

        $table = new Table($output);

        $header = array_keys($line['ticker']);
        array_unshift($header, 'market');
        array_unshift($header, 'time');

        $row = array_values($line['ticker']);
        array_unshift($row, $input->getArgument('market'));
        array_unshift($row, date('Y-m-d H:i:s', $line['at']));

        $table->setHeaders($header);
        $table->addRow($row);

        $table->render();
    }
}