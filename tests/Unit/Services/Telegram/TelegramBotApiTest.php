<?php


namespace Services\Telegram;


use Illuminate\Support\Facades\Http;

class TelegramBotApiTest extends \Tests\TestCase
{
    /**
     * @test
     */
    public function it_send_message_success() :void
    {
        Http::fake([
            TelegramBotApi::HOST .'*' => Http::response(['ok' => true],200)
        ]);
        $result = TelegramBotApi::sendMessage('',1,'Testing');
        $this->assertTrue($result);
    }

}
