<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ContactPersonPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        TextOutgoingMessage::make("Вкажіть прізвище, ім'я, по батькові контактної особи для зворотнього зв'язку", [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['contact_person'] = $message->getText();

        return $this->next(ContactPhonePage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
