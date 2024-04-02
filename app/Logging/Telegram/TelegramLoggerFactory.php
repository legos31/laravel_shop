<?php


namespace App\Logging\Telegram;

use App\Services\Telegram\TelegramBotApi;
use Monolog\Logger;

class TelegramLoggerFactory
{
    /**
     * Создать экземпляр собственного регистратора Monolog.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config) :Logger
    {
        $logger  = new Logger('telegram');
        $logger->pushHandler(new TelegramLoggerHandler($config));

        return $logger;
    }
}
