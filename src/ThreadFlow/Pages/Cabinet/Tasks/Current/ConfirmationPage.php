<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected $task;
    protected $status;
    protected $text;

    protected function show()
    {
        $lang = $this->session()->get('lang');

        $oldStatus = Task::getStatusByCode($this->task->status, $lang);
        $status = Task::getStatusByCode($this->status, $lang);
        $reminder = Task::getReminderTypeByCode($this->task->reminder, $lang);
        $deadline = $this->task->deadline
            ? $this->task->deadline->locale('uk')->isoFormat('dddd Do MMMM YYYY HH:mm')
            : 'Не встановлено';
        $message = implode("\n", [
            "Зміна статусу для завдання №{$this->task->id}",
            "Автор завдання: {$this->task->author_bot_user->fullName}",
            "Поточний статус завдання: {$oldStatus}",
            "Новий статус завдання: {$status}",
            "Кінцевий термін виконання: {$deadline}",
            "Нагадувати: {$reminder}",
            "Опис завдання: \n{$this->task->description}\n",
            "Коментар щодо зміни статусу: \n{$this->text}\n"
        ]);

        $this->reply(new TextOutgoingMessage($message, [
            ['save' => 'Все вірно, зберегти зміни'],
            ['cancel' => 'Відмінити']
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('cancel')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current\IndexPage::class);
        }
        if ($message->isText('save')) {
            $this->task->setNewStatus($this->status, $this->text);

            $this->reply(new TextOutgoingMessage('Дякуємо, зміни по завданню успішно збережені.'));
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        $this->show();
    }
}
