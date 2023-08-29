<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected $user;
    protected $deadline;
    protected $reminder;
    protected $text;

    protected function show()
    {
        $user = $this->user;
        $deadline = $this->deadline
            ? $this->deadline->isoFormat('dddd Do MMMM YYYY HH:mm')
            : 'Не встановлено';
        $reminder = Task::getReminderTypeByCode($this->reminder);

        $this->reply(new TextOutgoingMessage(
            "Завдання буде створене а повідомлення буде відправлено відповідному користувачу.\n".
            "Будь ласка перевірте усі дані та підтвердіть відправку.\n\n".
            "Зверніть увагу! Дана дія невідворотна!\n".
            'У наступному повідомлення буде текст який отримає користувач.'));
        $this->reply(new TextOutgoingMessage("Користувач: {$user['name']}\n".
            "Кінцевий термін виконання: {$deadline}\n".
            "Нагадувати: {$reminder}\n".
            "Опис завдання: \n{$this->text}\n", [
            ['send' => 'Все вірно, створити та надіслати'],
            ['back' => 'Назад']
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('send')) {
            $user = $this->user;
            $data = [
                'bot_user_id' => $user['id'],
                'author_bot_user_id' => $this->session()->get('user_id'),
                'deadline' => $this->deadline,
                'reminder' => $this->reminder,
                'description' => $this->text,
            ];
            if(Task::create($data)) {
                if ($this->session()->get('user_id') != $user['id']) {
                    $deadline = $this->deadline
                        ? $this->deadline->isoFormat('dddd Do MMMM YYYY HH:mm')
                        : 'Не встановлено';
                    $reminder = Task::getReminderTypeByCode($this->reminder);
                    $messageArray = [
                        "Для вас створено нове завдання\n",
                        "Автор завдання: {$user['name']}",
                        "Кінцевий термін виконання: {$deadline}",
                        "Нагадувати: {$reminder}",
                        "Опис завдання: \n{$this->text}"
                    ];

                    if ($botUser = BotUser::find($user['id'])) {
                        BotSendMessage::dispatch(implode("\n", $messageArray), null, $botUser);
                    }
                }

                $this->reply(new TextOutgoingMessage('Дякуємо, завдання створено а повідомлення успішно надіслано.'));
                return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
            }

            $this->reply(new TextOutgoingMessage('Завдання не створене. Спробуйте знову.'));
        }

        $this->show();
    }
}
