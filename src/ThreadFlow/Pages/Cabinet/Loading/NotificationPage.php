<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class NotificationPage extends AbstractPage
{
    protected $message;
    protected $loading;
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(
            implode("\n", [
                "=========================",
                "= 📦 нове розвантаження 📦 =",
                "=========================\n",
                "Привіт! У нас заплановано нове розвантаження",
                "Ми будемо дуже вдячні якщо у вас буде можливість допомогти\n",
                $this->message,
                "===========================",
                "=== 💙 ДЯКУЮ ЗА УВАГУ 💛 ===",
                "==========================="
            ]), [
                Button::text('💪 Я буду', 'accept'),
                Button::text('🚫 Нажаль не зможу бути', 'cancel')
            ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if ($message->isText('accept')) {
            $this->loading->bot_users()->attach([$this->session()->get('user_id') => ['is_confirmed' => 1]]);
            $this->reply(new TextOutgoingMessage("Дякуємо за підтримку 💪, до зустрічі!"));
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if ($message->isText('cancel')) {
            $this->loading->bot_users()->attach([$this->session()->get('user_id') => ['is_confirmed' => 0]]);
            $this->reply(new TextOutgoingMessage("Дякуємо за відповідь, до зустрічі наступного разу"));
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
    }
}
