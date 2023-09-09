<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class LoginPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage(__('To authorise, click the send contact button'), [
            Button::contact(__('Send a contact'), 'contact'),
            Button::contact(__('Back'), 'back')
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(IndexPage::class);
        }

        if ($message->isContact() && !empty($message->getPhoneNumber())) {
            $phoneNumber = $message->getPhoneNumber();
            if ($this->validatePhoneNumber($phoneNumber)) {
                $this->reply(new TextOutgoingMessage(__('Thank you, your contact has been received.')));
                $participant = $message->getContext()->getParticipant();
                return $this->next(EnterPasswordPage::class, ['login' => $phoneNumber, 'participant' => $participant])->withBreadcrumbs();
            } else {
                $this->reply(new TextOutgoingMessage(__('We\'re sorry, you can\'t log in using this phone number.')));
            }
        } else {
            $this->reply(new TextOutgoingMessage(__('Sorry, you need to send a contact for authorisation.')));
        }

        $this->show();
    }

    private function validatePhoneNumber(string $phoneNumber): bool
    {
        return true;
    }
}
