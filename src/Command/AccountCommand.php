<?php
/**
 * Create by lurrpis
 * Date 04/05/2017 6:37 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AccountCommand extends BaseCommand
{
    public static $name = 'account';

    protected function configure()
    {
        $this->setName(static::$name)->setDescription('Outputs \'Hello World\'');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table
            ->setHeaders(array('ISBN', 'Title', 'Author'))
            ->setRows(array(
                array('99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'),
                array('9971-5-0210-0', 'A Tale of Two Cities', 'Charles Dickens'),
                array('960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'),
                array('80-902734-1-6', 'And Then There Were None', 'Agatha Christie'),
            ))
        ;
        $table->render();
    }
}