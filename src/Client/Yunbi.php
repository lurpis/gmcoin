<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:40 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Client;

use Exception;

class Yunbi extends Client
{
    public static $apiUri = 'https://yunbi.com/api/v2';

    public static $accessKey;
    public static $secretKey;

    public static function instance()
    {
//        if(empty(static::$accessKey) || empty(static::$secretKey)) {
//            throw new Exception('need access key and secret key');
//        }

        return parent::instance();
    }

    public static function markets()
    {
        $uri = '/markets.json';

        return self::get($uri);
    }

    public static function deposits()
    {
        $uri = '/deposits.json';

        return self::get($uri);
    }

    public static function signature()
    {

    }
}