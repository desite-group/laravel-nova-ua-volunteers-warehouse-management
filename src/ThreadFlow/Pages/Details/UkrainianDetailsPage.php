<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details;

use App\Models\Detail;
use App\Models\Fundraising;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class UkrainianDetailsPage extends AbstractPage
{
    protected function show()
    {
        $messageArray = [
            __("Non-profit Organization \"Volunteers Support Ukraine\""),
            __("Ukraine, 79054, Lviv region, Lviv city, Girnyka Oleksy street, building 1"),
            __("EDRPOU code 44665073"),
            __("р/р UA463052990000026002000809161 в АТ КБ \"ПРИВАТБАНК\""),
            __("www.volunteers.support") . "\n",
            __("The head of the NGO \"VSU\" Zyla Roman Stepanovych")
        ];

        TextOutgoingMessage::make(implode("\n", $messageArray), [
            Button::text(__('Back'), 'back'),
            Button::text(__('To the main page'), 'general')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isText('general')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->show();
    }
}
