<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $botUser = BotUser::where('id', $this->session()->get('user_id'))->with('role.permissions')->first();
        $buttons = [
            Button::text('Ваші завдання', 'current')
        ];
        if ($botUser->role->permissions->where('code', 'task-creating')->first()) {
            $buttons[] =  Button::text('Створити завдання', 'new');
        }
        $this->reply(new TextOutgoingMessage("Планувальник завдань ГО \"ВПУ\"\n".
            "Виберіть будь ласка дію щоб продовжити", [
            $buttons,
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }
        if ($message->isText('current')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\Current\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('new')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask\IndexPage::class)->withBreadcrumbs();
        }
    }
}
