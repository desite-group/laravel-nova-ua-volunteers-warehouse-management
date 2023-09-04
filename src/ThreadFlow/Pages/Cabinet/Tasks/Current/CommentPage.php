<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class CommentPage extends AbstractPage
{
    protected $task;
    protected $status;

    protected function show()
    {
        $status = Task::getStatusByCode($this->status, $this->session()->get('lang'));
        $message = implode("\n", [
            "Актуалізація статусу для завдання №{$this->task->id}",
            "Новий статус: {$status}\n",
            "Будь ласка, введіть короткий коментар щодо поточного статусу даного завдання.",
            "Що вже зроблено, що залишилось зробити і т.д."
        ]);

        $this->reply(new TextOutgoingMessage($message, [
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if (!empty($message->getText())) {
            return $this->next(ConfirmationPage::class, [
                'task' => $this->task,
                'status' => $this->status,
                'text' => $message->getText()
            ])->withBreadcrumbs();
        }

        $this->show();
    }
}
