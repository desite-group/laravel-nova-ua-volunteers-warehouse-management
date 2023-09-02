<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ContactPhonePage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        TextOutgoingMessage::make("Вкажіть телефон контактної особи  для зворотнього зв'язку", [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['contact_phone'] = $message->getText();

        return $this->next(DescriptionPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
