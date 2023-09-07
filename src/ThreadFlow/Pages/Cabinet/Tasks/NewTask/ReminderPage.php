<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ReminderPage extends AbstractPage
{
    protected $user;
    protected $deadline;
    protected $text;

    protected function show()
    {
        $user = $this->user;
        $deadline = $this->deadline
            ? $this->deadline->isoFormat('dddd Do MMMM YYYY HH:mm')
            : 'Не встановлено';

        $lang = $this->session()->get('lang');
        $i = 0;
        foreach (Task::getReminderTypes($lang) as $key => $type) {
            $index = (string) floor($i / 2);
            $buttons[$index][$key] = $type;
            $i++;
        }
        $buttons[]['back'] = __('Back');
        $this->reply(new TextOutgoingMessage("Користувач: {$user['name']}\n".
            "Кінцевий термін виконання: {$deadline}\n".
            "Опис завдання: \n{$this->text}\n\n".
            "Виберіть коли бот повинен нагадувати користувачу за це завдання", $buttons));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('without')) {
            $reminder = null;
        } else {
            $reminder = $message->getText();
        }

        return $this->next(ConfirmationPage::class, [
            'user' => $this->user,
            'text' => $this->text,
            'deadline' => $this->deadline,
            'reminder' => $reminder,
        ])->withBreadcrumbs();
    }
}
