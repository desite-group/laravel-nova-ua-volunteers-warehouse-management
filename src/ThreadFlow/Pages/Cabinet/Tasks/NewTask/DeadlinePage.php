<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask;

use Exception;
use Illuminate\Support\Carbon;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class DeadlinePage extends AbstractPage
{
    protected $user;
    protected $text;

    protected function show()
    {
        $user = $this->user;
        $this->reply(new TextOutgoingMessage("Користувач: {$user['name']}\n".
            "Опис завдання: \n{$this->text}\n\n".
            "Напишіть дату та час доки потрібно виконати завдання у форматі 01.01.2023 12:00", [
            ['without' => 'Немає дедлайну'],
            ['back' => 'Назад']
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('without')) {
            $deadline = null;
        } else {
            try {
                $deadline = Carbon::parse($message->getText())->locale('uk');
            } catch (Exception $e) {
                $this->reply(new TextOutgoingMessage("Введений не вірний формат дати."));
                return $this->show();
            }
        }

        return $this->next(ReminderPage::class, [
            'user' => $this->user,
            'text' => $this->text,
            'deadline' => $deadline,
        ])->withBreadcrumbs();
    }
}
