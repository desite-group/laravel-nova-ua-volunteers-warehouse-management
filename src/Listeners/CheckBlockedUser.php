<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Listeners;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\LogBotMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\BlockedPage;
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
use SequentSoft\ThreadFlow\Page\PendingDispatchPage;
use SequentSoft\ThreadFlow\Session\PageState;

class CheckBlockedUser
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
        $participant = $event->getMessage()->getContext()->getParticipant();
        $botUser = BotUser::where('bot_user_id', $participant->getId())->withTrashed()->first();

        if ($participant->getLanguage() === 'ru' || !is_null($botUser->deleted_at)) {
            if (!is_null($botUser->deleted_at)) {
                $botUser->delete();
            }
            $pageState = $event->getPageState();
            $pageState->setPageClass(BlockedPage::class);
        }
    }
}
