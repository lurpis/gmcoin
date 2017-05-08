<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 2:40 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Client;

use Exception;
use GuzzleHttp\Client as HttpClient;

class Client
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    public static $apiUri;
    public static $contentType = 'application/json';
    public static $header = [];
    public static $timeout = 1;

    public static function instance()
    {
        if (empty(static::$apiUri)) {
            throw new Exception('lost api url');
        }

        $headers = static::$header + [
                'Content-Type' => static::$contentType,
                'Accept'       => static::$contentType,
            ];

        return new HttpClient([
            'base_uri' => static::$apiUri,
            'timeout'  => static::$timeout,
            'headers'  => $headers
        ]);
    }

    public static function get($uri, $params = [])
    {
        return static::send($uri, self::GET, $params);
    }

    public static function post($uri, $params = [])
    {
        return static::send($uri, self::POST, $params);
    }

    public static function put($uri, $params = [])
    {
        return static::send($uri, self::PUT, $params);
    }

    public static function delete($uri, $params = [])
    {
        return static::send($uri, self::DELETE, $params);
    }

    public static function send($uri, $method, $params)
    {
        $client = static::instance();

        try {
            $response = $client->request($method, $uri, $params);
            $data = $response->getBody()->getContents();

            return json_decode($data, true);
        } catch (Exception $exception) {
            print_r($exception->getMessage());

            return false;
        }
    }
}