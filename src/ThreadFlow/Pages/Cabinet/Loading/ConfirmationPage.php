<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Loading;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected $datetime;
    protected $location;
    protected $text;

    protected function show()
    {
        $this->reply(new TextOutgoingMessage(
            "Ваше повідомлення буде відправлено усім волонтерам авторизованим в даному боті.\n".
            "Будь ласка перевірте написаний текст та підтвердіть відправку.\n\n".
            "Зверніть увагу! Дана дія невідворотна!\n".
            'Текст який буде надіслано: '));

        $datetime = $this->datetime->isoFormat('dddd Do MMMM YYYY HH:mm');
        $this->reply(new TextOutgoingMessage(
            "Дата та час: {$datetime}\n".
            "Локація: {$this->location}\n\n".
            $this->text, [
            ['send' => 'Все вірно, надіслати'],
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('send')) {
            $data = [
                'author_bot_user_id' => $this->session()->get('user_id'),
                'datetime' => $this->datetime,
                'location' => $this->location,
                'description' => $this->text,
            ];
            if($loading = Loading::create($data)) {
                $datetime = $this->datetime->isoFormat('dddd Do MMMM YYYY HH:mm');
                $messageArray = [
                    "Дата та час: {$datetime}",
                    "Локація: {$this->location}\n",
                    $this->text
                ];

                $botUsers = BotUser::all();
                foreach ($botUsers as $botUser) {
                    BotSendMessage::dispatch(implode("\n", $messageArray), NotificationPage::class, $botUser, ['loading' => $loading]);
                }
                $this->reply(new TextOutgoingMessage('Дякуємо, ваше повідомлення успішно надіслано.'));
                return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
            }
        }

        $this->show();
    }
}
