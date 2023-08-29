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
                $message = 'Вкажіть код ЄДРПОУ організації яка потребує гуманітарної допомоги';
                break;

            case 'person':
                $message = "Вкажіть паспортні дані особи яка потребує гуманітарної допомоги\n".
                        "(Серія та номер паспорта, орган що видав паспорт та дату видачі)";
                break;
        }

        TextOutgoingMessage::make($message, [Button::text('Назад', 'back')])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['registration_data'] = $message->isText('unset') ? null : $message->getText();

        return $this->next(ContactPersonPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
