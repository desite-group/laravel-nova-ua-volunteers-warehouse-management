<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading;

use Carbon\Carbon;
use Exception;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage("Планується відправлення, розвантаження чи робота на складі?\n".
            "Напишіть дату та час збору у форматі 01.01.2023 12:00", [
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if (!empty($message->getText())) {
            try {
                $carbon = Carbon::parse($message->getText())->locale('uk');
            } catch (Exception $e) {
                $this->reply(new TextOutgoingMessage("Введений не вірний формат дати."));
                return $this->show();
            }

            return $this->next(LocationPage::class, ['datetime' => $carbon])->withBreadcrumbs();
        }

        $this->show();
    }
}
