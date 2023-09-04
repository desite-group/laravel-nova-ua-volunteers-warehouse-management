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
        if (!$event->getSession()->get('lang')) {
            $lang = 'uk';
            $event->getSession()->set('lang', $lang);
        } else {
            $lang = $event->getSession()->get('lang');
        }

        app('translator')->setLocale($lang);
    }
}
