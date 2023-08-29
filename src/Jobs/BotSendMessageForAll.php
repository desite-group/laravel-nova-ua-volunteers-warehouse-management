<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SequentSoft\ThreadFlow\Laravel\Facades\ThreadFlowBot;

class BotSendMessageForAll implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    public $page;
    public $excludedUserId;
    public $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $message, string $page = null, int $excludedUserId = null, ?array $parameters = [])
    {
        $this->message = $message;
        $this->page = $page;
        $this->excludedUserId = $excludedUserId;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $botUsers = BotUser::all();
        foreach ($botUsers as $botUser) {
            if ($botUser->id === $this->excludedUserId) {
                continue;
            }

            if (!$this->page) {
                ThreadFlowBot::channel('telegram')
                    ->sendMessage($botUser->bot_user_id, $this->message);

                break;
            }
            $parameters = array_merge($this->parameters, ['message' => $this->message]);
            ThreadFlowBot::channel('telegram')
                ->showPage($botUser->bot_user_id, $this->page, $parameters);
        }
    }
}
