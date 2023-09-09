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

    protected const expiredMessageArray = [
        "==============================",
        "= 🚨 ПРОТЕРМІНОВАНЕ ЗАВДАННЯ! 🚨 =",
        "==============================\n"
    ];

    protected const reminderMessageArray = [
        "===========================",
        "= 📌 Нагадування завдання! 📌 =",
        "===========================\n"
    ];

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
        if ($reminder === 'default') {
            $this->defaultFlow();
            return true;
        }

        if (!isset($reminderTypes[$reminder])) {
            $this->error(
                sprintf("ERROR! Reminder type %s not found!", $reminder));
            return false;
        }


        $tasks = Task::where('reminder', $reminder)->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task);
        }
    }

    private function defaultFlow()
    {
        $tasks = Task::whereNotNull('deadline')->where('deadline', Carbon::now()->addMinutes(-15))->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task, 'Залишилось ще 15 хвилин');
        }

        $tasks = Task::whereNotNull('deadline')->where('deadline', Carbon::now()->addHours(-2))->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task, 'Залишилось ще 2 години');
        }

        $tasks = Task::whereNotNull('deadline')->where('deadline', Carbon::now())->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task, 'Прийшов час виконати завдання');
        }

        $tasks = Task::whereNotNull('deadline')->where('deadline', Carbon::now()->addMinutes(15))->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task, 'Завдання протерміновано на 15 хвилин');
        }

        $tasks = Task::whereNotNull('deadline')->where('deadline', Carbon::now()->addHours(2))->active()->with('bot_user', 'author_bot_user')->get();
        foreach ($tasks as $task) {
            $this->sendTaskMessage($task, 'Завдання протерміновано на 2 години');
        }
    }

    private function sendTaskMessage($task, ?string $additionalLine = null)
    {
        $status = Task::getStatusByCode($task->status);
        $reminder = Task::getReminderTypeByCode($task->reminder);

        $messageArray = ($task->deadline < Carbon::now()) ? self::expiredMessageArray : self::reminderMessageArray;

        $deadline = $task->deadline
            ? $task->deadline->locale('uk')->isoFormat('dddd Do MMMM YYYY HH:mm')
            : 'Не встановлено';

        if ($additionalLine) {
            $messageArray[] = "\n" . $additionalLine . "\n";
        }

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
