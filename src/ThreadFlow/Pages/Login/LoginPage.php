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
        $this->reply(new TextOutgoingMessage('Для авторизації натисніть кнопку відправити контакт', [
            ['contact' => Button::contact('Відправити контакт')],
            ['back' => __('Back')]
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
                $this->reply(new TextOutgoingMessage('Дякуємо, ваш контакт отримано.'));
                return $this->next(EnterPasswordPage::class, ['login' => $phoneNumber])->withBreadcrumbs();
            } else {
                $this->reply(new TextOutgoingMessage('Вибачте, ви не можете авторизуватись за даним номером телефону.'));
            }
        } else {
            $this->reply(new TextOutgoingMessage('Вибачте, для авторизації потрібно відправити контакт.'));
        }

        $this->show();
    }

    private function validatePhoneNumber(string $phoneNumber): bool
    {
        return true;
    }
}
