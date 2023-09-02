<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class DescriptionPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        if ($this->data['type'] === 'person') {
            $messageArray = [
                "Опишіть детально кому потрібна ця допомога, додайте більше деталей, напишіть номер ВЧ\n",
                "Також напишіть будь ласка, через кому, у чому є потреба та у якій кількості."
            ];
        } else {
            $messageArray = [
                "Напишіть будь ласка, через кому, у чому є потреба та у якій кількості."
            ];
        }
        TextOutgoingMessage::make(implode("\n", $messageArray), [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $this->data['description'] = $message->getText();

        $application = Application::createFromBot($this->data);
        return $this->next(ApplicationUploadPage::class, ['application_id' => $application->id])->withBreadcrumbs();
    }
}
