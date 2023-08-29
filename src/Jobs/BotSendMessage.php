<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SequentSoft\ThreadFlow\Laravel\Facades\ThreadFlowBot;

class BotSendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    public $page;
    public $botUser;
    public $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $message, string $page = null, BotUser $botUser, array $parameters = [])
    {
        $this->message = $message;
        $this->page = $page;
        $this->botUser = $botUser;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->page) {
            ThreadFlowBot::channel('telegram')
                ->sendMessage($this->botUser->bot_user_id, $this->message);
        } else {
            $parameters = array_merge($this->parameters, ['message' => $this->message]);
            ThreadFlowBot::channel('telegram')
                ->showPage($this->botUser->bot_user_id, $this->page, $parameters);
        }
    }
}
