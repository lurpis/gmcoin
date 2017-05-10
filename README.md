<p align="center">
<a href="http://gmcloud.io/">
GMCoin
</a>
</p>
<p align="center">📦 Yunbi console client</p>

## Feature

 - 用服务器语言写的客户端程序;
 - 控制台买卖自己的加密数字货币;
 - 上班炒币利器;
 - 一条命令统计最近波段的盈亏明细;
 - 方法使用更优雅，不必再去研究那些奇怪的的方法名或者类名是做啥用的;
 - 符合 [PSR](https://github.com/php-fig/fig-standards) 标准，你可以各种方便的与你的框架集成;
 - PHP是世界上最好的语言;

## Requirement

1. PHP >= 5.5.9
2. **[composer](https://getcomposer.org/)**

> SDK 对所使用的框架并无特别要求

## Installation

```shell
composer require "lurrpis/gmcoin:~0.0.1" -vvv
```

## Usage

基本使用:

配置 AccessKey & SecretKey
```php
php bin/gmcoin config
```

获取账户余额
```php
php bin/gmcoin account
```

```
账号: hi@lurrpis.com
状态: 正常
ID: 76468220
+----------+---------------+--------+
| currency | balance       | locked |
+----------+---------------+--------+
| cny      | 1504.1025358  | 1715.8 |
| btc      | 0.0           | 0.0    |
| ltc      | 0.0           | 0.0    |
| doge     | 0.0           | 0.0    |
| bts      | 0.0           | 0.0    |
| bitcny   | 0.0           | 0.0    |
| bitusd   | 0.0           | 0.0    |
| bitbtc   | 0.0           | 0.0    |
| note     | 0.0           | 0.0    |
| pls      | 0.0           | 0.0    |
| nxt      | 0.0           | 0.0    |
| eth      | 0.0           | 0.0    |
| sc       | 19980.0       | 0.0    |
| dgd      | 0.0           | 0.0    |
| dcs      | 0.0           | 0.0    |
| dao      | 0.0           | 0.0    |
| etc      | 0.0           | 0.0    |
| amp      | 0.0           | 0.0    |
| 1st      | 4006.98605186 | 0.0    |
| rep      | 0.0           | 0.0    |
| ans      | 0.0           | 0.0    |
| zec      | 0.0           | 0.0    |
| zmc      | 0.0           | 0.0    |
| gnt      | 0.0           | 0.0    |
| yun      | 0.0           | 0.0    |
+----------+---------------+--------+
```

获取帮助
```php
php bin/gmcoin help
```

## Documentation

- 暂无

## Integration

- 暂无

## Contribution

- 暂无

## License

MIT
