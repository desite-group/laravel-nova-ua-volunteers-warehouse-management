<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class RecipientPersonPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        if ($this->data['type'] === 'person') {
            return $this->next(EdrpouPage::class, ['data' => $this->data])->withBreadcrumbs();
        }

        $message = '';
        switch ($this->data['type']) {
            case 'military':
                $message = __('Indicate the name of the unit commander in need of humanitarian assistance');
                break;
            case 'organization':
                $message = __('Indicate the name of the director of the organization that needs humanitarian assistance');
                break;
        }

        TextOutgoingMessage::make($message, [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            if ($this->data['type'] === 'person') {
                return $this->next(IndexPage::class);
            }

            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['recipient_person'] = $message->getText();

        return $this->next(EdrpouPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
