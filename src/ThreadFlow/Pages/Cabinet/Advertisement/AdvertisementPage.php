<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Advertisement;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class AdvertisementPage extends AbstractPage
{
    protected $message;
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(
            implode("\n", [
                "=============================",
                "= 🚨 ВАЖЛИВЕ ОГОЛОШЕННЯ! 🚨 =",
                "=============================\n",
                $this->message,
                "=============================",
                "=== 💙 ДЯКУЮ ЗА УВАГУ 💛 ===",
                "============================="
            ]), [
                Button::text('Зрозіміло', 'back')
            ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
    }
}
