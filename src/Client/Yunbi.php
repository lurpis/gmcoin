<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:40 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Client;

use Exception;
use GMCloud\GMCoin\App;

class Yunbi extends Client
{
    public static $apiUri = 'https://yunbi.com';

    public static function markets()
    {
        $uri = '/api/v2/markets.json';

        return self::get($uri);
    }

    public static function deposits()
    {
        $uri = '/api/v2/deposits.json';

        return self::get($uri);
    }

    public static function depth($params)
    {
        $uri = '/api/v2/depth.json';

        return self::get($uri, $params);
    }

    public static function orders()
    {
        $uri = '/api/v2/orders.json';

        $params = [
            'market' => '1stcny',
            'side'  => 'buy',
            'volume'    => '0.01',
            'price'     => '0.05',
            'ord_type'  => 'test'
        ];

        return self::post($uri, $params);
    }
}