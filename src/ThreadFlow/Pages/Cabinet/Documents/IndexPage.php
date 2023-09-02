<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Documents;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage('Виберіть дію з документами', [
            ['outgoing' => 'Новий акт на видачу', 'incoming' => 'Новий акт на отримання'],
            ['search' => 'Пошук документа'],
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if ($message->isText('outgoing')) {
            return $this->next(OutgoingPage::class)->withBreadcrumbs();
        }
        if ($message->isText('incoming')) {
            return $this->next(IncomingPage::class)->withBreadcrumbs();
        }
        if ($message->isText('search')) {
            return $this->next(SearchPage::class)->withBreadcrumbs();
        }

        $this->show();
    }
}
