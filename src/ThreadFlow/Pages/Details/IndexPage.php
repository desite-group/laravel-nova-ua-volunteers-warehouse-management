<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details;

use App\Models\Detail;
use App\Models\Fundraising;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $lang = $this->session()->get('lang');
        $generalDetails = Detail::whereIn('slug', ['mono', 'privat', 'paypal'])->get();
        $fundraisings = Fundraising::active()->opened()->get();

        $messageArray = [
            "Non-profit Organization \"Volunteers Support Ukraine\"",
            "Below are links to official bank accounts\n"
        ];

        if ($mono = $generalDetails->where('slug', 'mono')->first()) {
            $messageArray[] = __("Monobank jar") . ' ' . $mono->link . "\n";
        }

        if ($privat = $generalDetails->where('slug', 'privat')->first()) {
            $messageArray[] = __("Privat24") . ' ' . $privat->link . "\n";
        }

        if ($paypal = $generalDetails->where('slug', 'paypal')->first()) {
            $messageArray[] = "PayPal " . $paypal->link . "\n";
        }

        if ($fundraising = $fundraisings->where('is_general', 1)->first()) {
            $messageArray[] = __('Active collection on') . ': ' . $fundraising->getTranslation('title', $lang) . "\n";
            $messageArray[] = __('Collected') .": " . $fundraising->finalCollected . ' ' . __('UAH')
                . ' / ' . $fundraising->goal . ' ' . __('UAH') ."\n";
            $messageArray[] = __('Support') .": " . $fundraising->link . "\n";
        }

        $fundraisingButtons = [
            [
                Button::text(__('Details Ukraine'), 'ukrainian_details'),
                Button::text(__('International details'), 'international_details')
            ]
        ];
//        foreach ($fundraisings->where('is_general', 0)->all() as $fundraising) {
//            $fundraisingButtons[] = Button::text(__('Сollection') . ': ' . $fundraising->getTranslation('title', $lang), 'fundraising_'.$fundraising->id);
//        }
        $fundraisingButtons[] = Button::text(__('Back'), 'back');

        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        TextOutgoingMessage::make(__('More details'), $fundraisingButtons)->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isText('ukrainian_details')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details\UkrainianDetailsPage::class)
                ->withBreadcrumbs();
        }

        if ($message->isText('international_details')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details\InternationalDetailsPage::class)
                ->withBreadcrumbs();
        }

        $this->show();
    }
}
