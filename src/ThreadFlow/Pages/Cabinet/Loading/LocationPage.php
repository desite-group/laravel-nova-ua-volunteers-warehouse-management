<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class LocationPage extends AbstractPage
{
    protected $datetime;

    protected function show()
    {
        $datetime = $this->datetime->isoFormat('dddd Do MMMM YYYY HH:mm');
        $this->reply(new TextOutgoingMessage("Дата та час: {$datetime}\n".
            "Якщо час не вірний, натисніть назад щоб змінити.\n\n".
            "Напишіть адресу, або виберіть зі списку", [
            ['persenkivka' => 'м. Львів, вул. Персенківка 19'],
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('persenkivka')) {
            $location = 'м. Львів, вул. Персенківка 19';
        } else {
            $location = $message->getText();
        }

        return $this->next(CommentPage::class, [
            'datetime' => $this->datetime,
            'location' => $location,
        ])->withBreadcrumbs();
    }
}
