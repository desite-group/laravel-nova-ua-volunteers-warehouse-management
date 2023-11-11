<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Actions;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class BotUserSendMessage extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Send private message';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        if (!empty($fields->message)) {
            foreach ($models as $botUser) {
                BotSendMessage::dispatch($fields->message, null, $botUser);
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param NovaRequest $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Textarea::make(__('Message'), 'message')
        ];
    }
}
