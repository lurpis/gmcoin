<?php
/**
 * Create by lurrpis
 * Date 08/05/2017 5:29 PM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin;

use GMCloud\GMCoin\Command\AccountCommand;
use GMCloud\GMCoin\Command\MarketCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\EventDispatcher\EventDispatcher;
use RuntimeException;

class App
{
    const APP = 'GMCoin';
    const VERSION = '0.0.1';
    const ACCESS_KEY = 'ACCESS_KEY';
    const SECRET_KEY = 'SECRET_KEY';

    public static $command = [
        AccountCommand::class,
        MarketCommand::class
    ];

    public static $keyCommand = [
        AccountCommand::class,
        MarketCommand::class
    ];

    public static $secretPath = './.secret';
    public static $accessKey;
    public static $secretKey;

    /**
     * @var Application $console
     */
    protected $console;

    public function addCommand()
    {
        foreach (static::$command as $item) {
            $this->console->add(new $item());
        }
    }

    public function addEvent()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(ConsoleEvents::COMMAND, function (ConsoleCommandEvent $event) {
            // get the input instance
            $input = $event->getInput();

            // get the output instance
            $output = $event->getOutput();

            // get the command to be executed
            $command = $event->getCommand();

            foreach (static::$keyCommand as $item) {
                if ($item::$name == $command->getName()) {
                    $helper = $command->getHelper('question');

                    static::$accessKey = static::getKeySecretFile(static::ACCESS_KEY);
                    if (empty(static::$accessKey)) {
                        $question = new Question('Please enter the AccessKey: ');

                        $question->setValidator(function ($answer) {
                            preg_match("/^[a-z0-9A-Z_]*$/", $answer, $match);
                            if (empty($match)) {
                                throw new RuntimeException('The AccessKey incorrect');
                            }

                            return $answer;
                        });

                        $question->setMaxAttempts(2);

                        if (static::setKeySecretFile(static::ACCESS_KEY, $helper->ask($input, $output, $question))) {
                            $output->writeln(sprintf('<info>AccessKey 设置成功!</info>'));
                        }
                    }

                    static::$secretKey = static::getKeySecretFile(static::SECRET_KEY);
                    if (empty(static::$secretKey)) {
                        $question = new Question('Please enter the SecretKey: ');

                        $question->setValidator(function ($answer) {
                            preg_match("/^[a-z0-9A-Z_]*$/", $answer, $match);
                            if (empty($match)) {
                                throw new RuntimeException('The SecretKey incorrect');
                            }

                            return $answer;
                        });

                        $question->setMaxAttempts(2);

                        if (static::setKeySecretFile(static::SECRET_KEY, $helper->ask($input, $output, $question))) {
                            $output->writeln(sprintf('<info>SecretKey 设置成功!</info>'));
                        }
                    }
                }
            }
        });

        $this->console->setDispatcher($dispatcher);
    }

    protected static function getKeySecretFile($key)
    {
        preg_match("/^{$key}=[a-z0-9A-Z_]*/m", file_get_contents(static::$secretPath), $match);

        $value = '';
        if (!empty($match[0])) {
            $value = explode('=', $match[0])[1];
        }

        return $value;
    }

    protected static function setKeySecretFile($key, $value)
    {
        return file_put_contents(static::$secretPath,
            preg_replace(static::keyReplacementPattern($key), "{$key}={$value}",
                file_get_contents(static::$secretPath)));
    }

    protected static function keyReplacementPattern($key)
    {
        $escaped = preg_quote(static::getKeySecretFile($key), '/');

        return "/^{$key}={$escaped}/m";
    }

    public function run()
    {
        $this->console = new Application(self::APP, self::VERSION);

        $this->addCommand();
        $this->addEvent();

        $this->console->run();
    }
}