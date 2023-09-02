<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class TaskPage extends AbstractPage
{
    protected $task;
    protected $task_id;

    protected function show()
    {
        $this->task = $this->getUserTask($this->task_id);

        if (!$this->task) {
            $this->reply(new TextOutgoingMessage('Нажаль дане завдання не знайдено. Будь ласка спробуйте інше.', [
                ['back' => __('Back')]
            ]));
        } else {
            $reminder = Task::getReminderTypeByCode($this->task->reminder);
            $deadline = $this->task->deadline
                ? $this->task->deadline->locale('uk')->isoFormat('dddd Do MMMM YYYY HH:mm')
                : 'Не встановлено';
            $message = implode("\n", [
                "Деталі про завдання №{$this->task->id}",
                "Автор завдання: {$this->task->author_bot_user->fullName}",
                "Кінцевий термін виконання: {$deadline}",
                "Нагадувати: {$reminder}",
                "Опис завдання: \n{$this->task->description}\n",
                "Виберіть відповідний статус даного завдання"
            ]);

            $this->reply(new TextOutgoingMessage($message, [
                ['completed' => 'Завдання виконане', 'later' => 'Нагадати пізніше'],
                ['canceled' => 'Завдання неможливо виконати', 'back' => __('Back')]
            ]));
        }
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        if (Task::getStatusByCode($message->getText())) {
            return $this->next(CommentPage::class, ['task' => $this->task, 'status' => $message->getText()])
                ->withBreadcrumbs();
        }

        $this->show();
    }

    private function getUserTask($taskId): ?Task
    {
        return Task::where('id', $taskId)
            ->where('bot_user_id', $this->session()->get('user_id'))
            ->active()
            ->first();
    }
}
