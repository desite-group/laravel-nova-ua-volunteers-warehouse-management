<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ReminderPage extends AbstractPage
{
    protected $message;
    protected $task;
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(
            $this->message, [
                [
                    Button::text('Завдання виконане', 'completed'),
                    Button::text('Завдання неможливо виконати', 'canceled')
                ],
                [
                    Button::text('Нагадати пізніше', 'back')
                ]
            ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if ($message->isText('completed')) {
            $this->task->setNewStatus('completed');

            $this->reply(new TextOutgoingMessage('Дякуємо за виконання завдання. Статус змінено.'));
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if (Task::getStatusByCode($message->getText())) {
            return $this->next(CommentPage::class, ['task' => $this->task, 'status' => $message->getText()])
                ->withBreadcrumbs();
        }
    }
}
