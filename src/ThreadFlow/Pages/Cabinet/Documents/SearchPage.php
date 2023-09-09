<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Documents;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class SearchPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(__('Search for a document in the system. Select a search criterion'), [
            ['number' => __('By document number'), 'date' => __('By date')],
            ['phone' => __('By the recipient\'s phone'), 'name' => __('By the recipient\'s name')],
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
