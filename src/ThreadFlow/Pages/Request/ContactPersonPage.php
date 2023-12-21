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
        TextOutgoingMessage::make(__("Specify the name, surname, patronymic of the contact person for feedback"), [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\IndexPage::class);
        }

        $this->data['contact_person'] = $message->getText();

        return $this->next(ContactPhonePage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
