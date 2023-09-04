<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make(__('Choose the type that corresponds to your request'), [
           Button::text(__('Request from the Military Unit'), 'military'),
           Button::text(__('Request from the Organization'), 'organization'),
           Button::text(__('Request from a individual (including military personnel'), 'person'),
           Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isText('military') || $message->isText('organization') || $message->isText('person')) {
            return $this->next(ApplicationSamplesPage::class, ['data' => ['type' => $message->getText()]])->withBreadcrumbs();
        }

        TextOutgoingMessage::make(__('The type is not correct. Try using the keyboard.'))->reply();
        $this->show();
    }
}
