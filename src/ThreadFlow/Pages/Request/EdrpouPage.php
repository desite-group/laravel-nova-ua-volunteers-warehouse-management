<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class EdrpouPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        if ($this->data['type'] === 'military') {
            return $this->next(ContactPersonPage::class, ['data' => $this->data])->withBreadcrumbs();
        }

        $message = '';
        switch ($this->data['type']) {
            case 'organization':
                $message = __('Specify the EDRPOU code of the organization that needs humanitarian assistance');
                break;

            case 'person':
                $message = __("Specify the passport data of the person in need of humanitarian assistance") . "\n" .
                        __("(Passport series and number, passport issuing authority and date of issue)");
                break;
        }

        TextOutgoingMessage::make($message, [Button::text(__('Back'), 'back')])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\IndexPage::class);
        }

        $this->data['registration_data'] = $message->isText('unset') ? null : $message->getText();

        return $this->next(ContactPersonPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
