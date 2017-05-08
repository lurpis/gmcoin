#!/usr/bin/env php

<?php
/**
 * Create by lurrpis
 * Date 04/05/2017 5:57 PM
 * Blog lurrpis.com
 */

set_time_limit(0);

require __DIR__ . '/../../vendor/autoload.php';

use GMCloud\GMCoin\App;

//$consoleRoot = __DIR__ . '/../';
//
//if (file_exists($consoleRoot . 'vendor/autoload.php')) {
//    include_once $consoleRoot . 'vendor/autoload.php';
//} elseif (file_exists($consoleRoot . '../../autoload.php')) {
//    include_once $consoleRoot . '../../autoload.php';
//} else {
//    echo 'Something goes wrong with your archive' . PHP_EOL . 'Try downloading again' . PHP_EOL;
//    exit(1);
//}

(new App())->run();