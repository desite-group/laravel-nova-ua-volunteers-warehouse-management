<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class CommentPage extends AbstractPage
{
    protected $datetime;
    protected $location;
    protected function show()
    {
        $datetime = $this->datetime->isoFormat('dddd Do MMMM YYYY HH:mm');
        $this->reply(new TextOutgoingMessage(__("Date and time:") . " " .  $datetime . "\n" .
            __("Location:") . " " .  $this->location . "\n\n" .
            __("Write a short description of the event") , [
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if (!empty($message->getText())) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading\ConfirmationPage::class, [
                'datetime' => $this->datetime,
                'location' => $this->location,
                'text' => $message->getText(),
            ])->withBreadcrumbs();
        }

        $this->show();
    }
}
