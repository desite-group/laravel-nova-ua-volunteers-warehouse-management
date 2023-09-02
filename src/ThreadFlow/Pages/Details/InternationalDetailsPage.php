<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details;

use App\Models\Detail;
use App\Models\Fundraising;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class InternationalDetailsPage extends AbstractPage
{
    protected function show()
    {
        $details = Detail::whereIn('slug', ['USD', 'EUR', 'GBP'])->get();

        TextOutgoingMessage::make(__('Details for international transfers') . "\n")->reply();

        foreach ($details as $detail) {
            $messageArray = [
                $detail->title,
                strip_tags(str_replace("&nbsp;", "",str_replace("</p><p>", "</p>\n<p>", $detail->description))) . "\n"
            ];
            TextOutgoingMessage::make(implode("\n", $messageArray), [
                Button::text(__('Back'), 'back'),
                Button::text(__('To the main page'), 'general')
            ])->reply();
        }
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isText('general')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->show();
    }
}
