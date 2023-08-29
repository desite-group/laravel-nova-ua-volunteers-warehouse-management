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
        TextOutgoingMessage::make('Виберіть тип який відповідає вашому запиту', [
           Button::text('Запит від Військової Частини', 'military'),
           Button::text('Запит від Організації', 'organization'),
           Button::text('Запит від фізичної особи (у т.ч. військовослужбовця)', 'person'),
           Button::text('Назад', 'back')
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

        TextOutgoingMessage::make('Вибраний не вірний тип. Спробуйте скористатись клавіатурою.')->reply();
        $this->show();
    }
}
