<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class CommentPage extends AbstractPage
{
    protected $user;
    protected function show()
    {
        $user = $this->user;
        $this->reply(new TextOutgoingMessage("Користувач: {$user['name']}\n\n".
            "Напишіть короткий опис завдання", [
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if (!empty($message->getText())) {
            return $this->next(DeadlinePage::class, [
                'user' => $this->user,
                'text' => $message->getText(),
            ])->withBreadcrumbs();
        }

        $this->show();
    }
}
