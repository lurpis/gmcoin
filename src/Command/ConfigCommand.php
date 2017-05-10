<?php
/**
 * Create by lurrpis
 * Date 09/05/2017 11:17 AM
 * Blog lurrpis.com
 */

namespace GMCloud\GMCoin\Command;

use RuntimeException;
use GMCloud\GMCoin\App;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigCommand extends BaseCommand
{
    public static $name = 'config';

    protected function configure()
    {
        $this->setName(static::$name)->setDescription('Set AccessKey & SecretKey')->setDefinition(new InputDefinition([
                new InputOption('force', 'f', null, 'Forced reset AccessKey/SecretKey'),
            ]));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('force')) {
            $this->config($input, $output);
        } else if (!empty(App::$secretKey) || !empty(App::$accessKey)) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion('Already exist AccessKey/SecretKey, Continue with reset? [y/n] ',
                false, '/^(y|j)/i');

            if ($helper->ask($input, $output, $question)) {
                $this->config($input, $output);
            }
        } else {
            $this->config($input, $output);
        }
    }

    public function config(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $accessQuestion = new Question('Please enter the AccessKey: ');

        $accessQuestion->setValidator(function ($answer) {
            preg_match("/^[a-z0-9A-Z_]*$/", $answer, $match);
            if (empty($match)) {
                throw new RuntimeException('The AccessKey incorrect');
            }

            return $answer;
        });

        $accessQuestion->setMaxAttempts(2);

        $accessKey = $helper->ask($input, $output, $accessQuestion);
        if (App::setKeySecretFile(App::ACCESS_KEY, $accessKey)) {
            App::initialize();
            $output->writeln(sprintf('<info>Set AccessKey successfully!</info>'));
        }

        $secretQuestion = new Question('Please enter the SecretKey: ');

        $secretQuestion->setValidator(function ($answer) {
            preg_match("/^[a-z0-9A-Z_]*$/", $answer, $match);
            if (empty($match)) {
                throw new RuntimeException('The SecretKey incorrect');
            }

            return $answer;
        });

        $secretQuestion->setMaxAttempts(2);

        $secretKey = $helper->ask($input, $output, $secretQuestion);
        if (App::setKeySecretFile(App::SECRET_KEY, $secretKey)) {
            App::initialize();
            $output->writeln(sprintf('<info>Set SecretKey successfully!</info>'));
        }
    }
}