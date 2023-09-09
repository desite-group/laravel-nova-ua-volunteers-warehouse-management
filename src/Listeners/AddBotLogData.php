<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Listeners;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\LogBotMessage;
use SequentSoft\ThreadFlow\Events\Message\IncomingMessageProcessingEvent;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\AudioIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\ContactIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\FileIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\ImageIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\LocationIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\StickerIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\TextIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Incoming\Regular\VideoIncomingRegularMessage;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\FileOutgoingMessage;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\ForwardOutgoingMessage;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\ImageOutgoingMessage;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;

class AddBotLogData
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
        $message = $event->getMessage();
        $pageClass = str_replace('DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\\', '', $event->getSession()->getPageState()->getPageClass());

        $participant = $message->getContext()->getParticipant();
        if ($event instanceof IncomingMessageProcessingEvent) {
            $data = [
                'username' => $participant->getUsername(),
                'first_name' => $participant->getFirstName(),
                'last_name' => $participant->getLastName(),
                'language_code' => $participant->getLanguage(),
                'photo_url' => $participant->getPhotoUrl()
            ];
        } else {
            $data = [];
        }

        $botUser = BotUser::withTrashed()->firstOrCreate(['bot_user_id' => $participant->getId()], $data);

        LogBotMessage::create([
            'bot_user_id' => $botUser->id,
            'message' => mb_substr($this->getMessageText($message), 0, 255),
            'page_class' => $pageClass,
        ]);
    }

    private function getMessageText($message)
    {
        if ($message instanceof TextIncomingRegularMessage) {
            return $message->getText();
        }

        if ($message instanceof AudioIncomingRegularMessage) {
            return __('Received audio');
        }

        if ($message instanceof ContactIncomingRegularMessage) {
            return __('Contact received');
        }

        if ($message instanceof ImageIncomingRegularMessage) {
            return __('Image received');
        }

        if ($message instanceof FileIncomingRegularMessage) {
            return __('File received');
        }

        if ($message instanceof LocationIncomingRegularMessage) {
            return __('Location received');
        }

        if ($message instanceof StickerIncomingRegularMessage) {
            return __('Received a sticker');
        }

        if ($message instanceof VideoIncomingRegularMessage) {
            return __('Video received');
        }


        if ($message instanceof TextOutgoingMessage) {
            return $message->getText();
        }

        if ($message instanceof ForwardOutgoingMessage) {
            return __('Message sent');
        }

        if ($message instanceof ImageOutgoingMessage) {
            return __('Image sent');
        }

        if ($message instanceof FileOutgoingMessage) {
            return __('File sent');
        }

        return __('Message type is not defined');
    }
}
