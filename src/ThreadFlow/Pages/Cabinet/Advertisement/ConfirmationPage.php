<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Advertisement;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessageForAll;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected $text;

    protected function show()
    {
        TextOutgoingMessage::make(
            "Ваше повідомлення буде відправлено усім волонтерам авторизованим в даному боті.\n".
            "Будь ласка перевірте написаний текст та підтвердіть відправку.\n\n".
            "Зверніть увагу! Дана дія невідворотна!\n".
            'Текст який буде надіслано: ')->reply();
        TextOutgoingMessage::make($this->text, [
            Button::text('Все вірно, надіслати', 'send'),
            Button::text('Назад', 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('send')) {
            BotSendMessageForAll::dispatch($this->text, AdvertisementPage::class, $this->session()->get('user_id'));
            $this->reply(new TextOutgoingMessage('Дякуємо, ваше повідомлення успішно надіслано.'));
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        $this->show();
    }
}
