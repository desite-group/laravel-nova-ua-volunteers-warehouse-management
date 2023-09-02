<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Warehouse;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage('Виберіть дію яку потрібно виконати', [
            ['by_name' => 'Пошук по назві', 'by_article' => 'Пошук по артикулу'],
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if ($message->isText('by_name')) {
            return $this->next(SearchPage::class, ['type' => 'name'])->withBreadcrumbs();
        }
        if ($message->isText('by_article')) {
            return $this->next(SearchPage::class, ['type' => 'article'])->withBreadcrumbs();
        }

        $this->show();
    }
}
