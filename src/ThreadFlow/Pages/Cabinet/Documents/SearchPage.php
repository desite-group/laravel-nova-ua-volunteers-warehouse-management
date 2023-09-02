<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Documents;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class SearchPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage('Пошук документа по системі. Виберіть критерій пошуку', [
            ['number' => 'По номеру документа', 'date' => 'По даті'],
            ['phone' => 'По телефону отримувача', 'name' => 'По імені отримувача'],
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        $this->show();
    }
}
