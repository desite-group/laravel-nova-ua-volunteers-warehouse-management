<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login\LoginPage;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class BlockedPage extends AbstractPage
{
    protected function show()
    {
        $messageArray = [
            "Слава Україні!🇺🇦",
            "🚫Вам заблоковано доступ!🚫",
            "👮Причина: Вас ідентифіковано як 🐷росіянина!"."\n",
            "Це не так? Шкода, адже мова вашого додатку говорить про інше.",
            "До чого тут мова? Якщо ви на вулиці чуєте іспанську то скоріш за все від іспанця, якщо німецьку то від німця.",
            "Продожуючи логічний ряд:",
            "Якщо чути 🤮російську то від 🐷росіянина!"."\n",
            "Тому якщо ви не хочете щоб у всьому світі вас ідентифікували як 🐷росіянина через ваш 🤮\"язик\", пора вчити 🇺🇦мову!"."\n",
            "\"Хто нікчемну душу має, то така ж у нього мова.\" (Леся Українка)."."\n",
            "Разом до перемоги!💙💛",
        ];

        TextOutgoingMessage::make(implode("\n", $messageArray), [
            Button::text('Героям Слава!🇺🇦', 'ukraine')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('ukraine')) {
            $participant = $message->getContext()->getParticipant();
            $botUser = BotUser::where('bot_user_id', $participant->getId())->first();

            if ($botUser && is_null($botUser->deleted_at)) {
                return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class)->withBreadcrumbs();
            }
        }

        $this->show();
    }
}
