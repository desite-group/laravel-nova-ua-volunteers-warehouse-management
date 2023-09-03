<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Listeners;

class LocalizationBotUpdate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(string $channelName, $event)
    {
        $lang = $event->getSession()->get('lang') ?? 'uk';
        app('translator')->setLocale($lang);
    }
}
