<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $tasks = $this->getUserCurrentTasksData();

        $buttons = [];
        if ($tasks) {
            $tasks['messages'][] = "Виберіть завдання з яким хочете виконати дію";
            $message = implode("\n\n", $tasks['messages']);

            $i = 0;
            foreach ($tasks['buttons'] as $key => $type) {
                $index = (string) floor($i / 2);
                $buttons[$index][$key] = $type;
                $i++;
            }
        } else {
            $message = 'Ви молодець! Усі ваші завдання виконані.';
        }
        $buttons[]['back'] = 'Назад';

        $this->reply(new TextOutgoingMessage($message, $buttons));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        return $this->next(TaskPage::class, ['task_id' => $message->getText()])->withBreadcrumbs();
    }

    private function getUserCurrentTasksData()
    {
        $tasks = Task::where('bot_user_id', $this->session()->get('user_id'))->active()->get();

        if (!$tasks->count()) {
            return null;
        }

        $messages = [];
        $buttons = [];
        foreach (Task::where('bot_user_id', $this->session()->get('user_id'))->active()->get() as $task){
            $reminder = Task::getReminderTypeByCode($task->reminder);
            $deadline = $task->deadline
                ? $task->deadline->locale('uk')->isoFormat('dddd Do MMMM YYYY HH:mm')
                : 'Не встановлено';
            $messages[] = implode("\n", [
                "Автор завдання: {$task->author_bot_user->fullName}",
                "Кінцевий термін виконання: {$deadline}",
                "Нагадувати: {$reminder}",
                "Опис завдання: \n{$task->description}"
            ]);

            $buttons[$task->id] = '№' . $task->id . ' ' . mb_substr($task->description, 0, 25) . '...';
        }

        return [
            'messages' => $messages,
            'buttons' => $buttons
        ];
    }
}
