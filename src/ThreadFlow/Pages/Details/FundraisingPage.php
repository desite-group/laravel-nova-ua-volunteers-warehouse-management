<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details;

use App\Models\Detail;
use App\Models\Fundraising;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class FundraisingPage extends AbstractPage
{
    protected $fundraising_id;
    protected function show()
    {
        if ($fundraising = Fundraising::active()->opened()->find($this->fundraising_id))
        {
            $lang = $this->session()->get('lang');

            $messageArray = [
                __('Collection') . ': ' . $fundraising->getTranslation('title', $lang) . "\n",
                strip_tags($fundraising->getTranslation('description', $lang)) . "\n",
                __('Collected') .": " . $fundraising->finalCollected . ' ' . __('UAH')
                . ' / ' . $fundraising->goal . ' ' . __('UAH') ."\n",
                __('Support') .": " . $fundraising->link . "\n"
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
