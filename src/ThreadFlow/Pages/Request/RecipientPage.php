<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class RecipientPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        if ($this->data['type'] === 'person') {
            return $this->next(RecipientPersonPage::class, ['data' => $this->data])->withBreadcrumbs();
        }

        $message = '';
        switch ($this->data['type']) {
            case 'military':
                $message = 'Вкажіть назву військової частини, яка потребує гуманітарної допомоги';
                break;
            case 'organization':
                $message = 'Вкажіть повну юридичну назву організації, яка потребує гуманітарної допомоги';
                break;
        }

        TextOutgoingMessage::make($message, [
            Button::text('Назад', 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->next(IndexPage::class);
        }

        $this->data['recipient'] = $message->getText();

        return $this->next(RecipientPersonPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
