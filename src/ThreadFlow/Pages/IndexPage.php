<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login\LoginPage;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $this->reply(new TextOutgoingMessage("Дисклеймер: Це АЛЬФА версія бота ще не має повного функціорналу. На даний момент побудована лише ще не фінальна структура майбутнього функціоналу."));

        $this->reply(new TextOutgoingMessage("Вас вітає офіційний бот ГО \"Волонтерська Підтримка України\"\n\n".
            "Виберіть будь ласка потрібну дію",  [
            ['request' => '📄 Залишити звернення на отримання допомоги'],
            ['question' => '📝 Написати питання чи побажання до ГО "ВПУ"'],
            ['login' => '🔒 Авторизуватись як волонтер']
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('request')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\IndexPage::class)->withBreadcrumbs();
        }

        if ($message->isText('question')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Question\IndexPage::class)->withBreadcrumbs();
        }

        if ($message->isText('login')) {
            return $this->next(LoginPage::class)->withBreadcrumbs();
        }

        $this->show();
    }
}
