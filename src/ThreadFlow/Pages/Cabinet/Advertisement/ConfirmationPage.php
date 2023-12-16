<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Advertisement;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected $text;

    protected function show()
    {
        TextOutgoingMessage::make(
            __("Your message will be sent to all volunteers logged in to this bot.") . "\n".
            __("Please check the written text and confirm sending") . "\n\n".
            __("Please note! This action is inevitable!") . "\n".
            __('The text that will be sent:') )->reply();
        TextOutgoingMessage::make($this->text, [
            Button::text(__('That\'s right, send'), 'send'),
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('send')) {
            $botUsers = BotUser::all();
            foreach ($botUsers as $botUser) {
                if ($botUser->id === $this->session()->get('user_id')) {
                    continue;
                }

                BotSendMessage::dispatch($this->text, AdvertisementPage::class, $botUser->bot_user_id);
            }

            TextOutgoingMessage::make(__('Thank you, your message has been sent successfully.'))->reply();
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        $this->show();
    }
}
