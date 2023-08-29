<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Warehouse;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class SearchPage extends AbstractPage
{
    protected $type;

    protected function show()
    {
        $type = $this->type === 'article' ? 'артикул' : 'назву';
        $this->reply(new TextOutgoingMessage('Введіть '.$type.' для пошуку', [
            ['back' => 'Назад']
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        return $this->next(ResultPage::class, [
            'type' => $this->type,
            'text' => $message->getText()])->withBreadcrumbs();
    }
}
