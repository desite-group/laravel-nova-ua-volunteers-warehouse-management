<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Console\Commands;

use Carbon\Carbon;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Task;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current\ReminderPage;
use Illuminate\Console\Command;

class BotTaskReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:task-reminder {reminder*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron reminder user for active task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reminderTypes = Task::getReminderTypes();
        $reminder = collect($this->argument('reminder'))->first();
        if (!isset($reminderTypes[$reminder])) {
            $this->error(
                sprintf("ERROR! Reminder type %s not found!", $reminder));
            return false;
        }

        $tasks = Task::where('reminder', $reminder)->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $lang = $this->session()->get('lang');

            $status = Task::getStatusByCode($task->status, $lang);
            $reminder = Task::getReminderTypeByCode($task->reminder, $lang);

            if ($task->deadline < Carbon::now()) {
                $messageArray = [
                    "==============================",
                    "= 🚨 ПРОТЕРМІНОВАНЕ ЗАВДАННЯ! 🚨 =",
                    "==============================\n"
                ];
            } else {
                $messageArray = [
                    "===========================",
                    "= 📌 Нагадування завдання! 📌 =",
                    "===========================\n"
                ];
            }

            $deadline = $task->deadline
                ? $task->deadline->locale('uk')->isoFormat('dddd Do MMMM YYYY HH:mm')
                : 'Не встановлено';
            $messageArray = array_merge($messageArray, [
                "Завдання №{$task->id}",
                "Автор завдання: {$task->author_bot_user->fullName}",
                "Поточний статус завдання: {$status}",
                "Кінцевий термін виконання: {$deadline}",
                "Нагадувати: {$reminder}",
                "Опис завдання: \n{$task->description}\n",
                "==========================",
                "=== 💙 ДЯКУЮ ЗА УВАГУ 💛 ===",
                "=========================="
            ]);

            BotSendMessage::dispatch(implode("\n", $messageArray), ReminderPage::class, $task->bot_user, ['task' => $task]);

        }
    }
}
