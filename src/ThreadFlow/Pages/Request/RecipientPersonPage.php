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
                $message = 'Вкажіть ПІБ командира, яка потребує гуманітарної допомоги';
                break;
            case 'organization':
                $message = 'Вкажіть ПІБ директора організації, яка потребує гуманітарної допомоги';
                break;
        }

        TextOutgoingMessage::make($message, [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['recipient_person'] = $message->getText();

        return $this->next(EdrpouPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
