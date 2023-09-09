<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Documents;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IncomingPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(__('Creating a new certificate of receipt'), [
            Button::contact(__('Back'), 'back')
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
