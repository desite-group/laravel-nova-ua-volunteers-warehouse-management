<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotRole;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SequentSoft\ThreadFlow\Laravel\Facades\ThreadFlowBot;

class BotSendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    public $page;
    public $users;
    public $roles;
    public $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $message, array $users = [], array $roles = [], string $page = null, array $parameters = [])
    {
        $this->message = $message;
        $this->page = $page;
        $this->users = $users;
        $this->roles = $roles;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $botUsers = [];

        if (!empty($this->users)) {
            $users = BotUser::whereIn('id', $this->roles)->get();

            foreach ($users as $user) {
                $botUsers[$user->id] = $user;
            }
        }
        if (!empty($this->roles)) {
            $roles = BotRole::whereIn('code', $this->roles)->with('users')->get();
            foreach ($roles as $role) {
                if (!empty($role->users)) {
                    foreach ($role->users as $user) {
                        $botUsers[$user->id] = $user;
                    }
                }
            }
        }

        foreach ($botUsers as $botUser) {
            BotSendMessage::dispatch($this->message, null, $botUser);
        }
    }
}
