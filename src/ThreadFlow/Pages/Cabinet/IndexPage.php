<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make(
            "Дисклеймер: Це АЛЬФА версія бота яка ще не має повного функціорналу. На даний момент побудована лише частина функціоналу та пройдене первинне тестування. Але в Боті можуть бути баги які ми не відловили на тестуванні, якщо ви стикнулись з певною проблемою, будь ласка напишіть @RomanZhyla")
            ->reply();

        $buttons = $this->getUserButtons();
        if (count($buttons) < 1){
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        TextOutgoingMessage::make(
            "Вас вітає кабінет волонтера ГО \"Волонтерська Підтримка України\"\n\n".
            'Виберіть розділ у якому хочете виконати дію', $buttons)
            ->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('exit')) {
            $this->session()->delete('user_id');
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isText('documents')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Documents\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('warehouse')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Warehouse\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('task')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('media')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Media\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('loading')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Loading\IndexPage::class)->withBreadcrumbs();
        }
        if ($message->isText('advertisement')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Advertisement\IndexPage::class)->withBreadcrumbs();
        }

        $this->show();
    }

    private function getUserButtons(): array
    {
        $buttons = [];
        $result = [];
        $botUserId = $this->session()->get('user_id');
        if (!$botUserId){
            return [];
        }

        $botUser = BotUser::where('id', $botUserId)->with('role.permissions')->first();
        if (!empty($botUser->role->permissions)) {
            $permissions = $botUser->role->permissions;

            if ($permissions->where('code', 'documents')->first()) {
                $buttons['documents'] = 'Робота з документами';
            }
            if ($permissions->where('code', 'warehouse')->first()) {
                $buttons['warehouse'] = 'Робота з складом';
            }
            if ($permissions->where('code', 'task')->first()) {
                $buttons['task'] = '📋 Менеджер завдань';
            }
            if ($permissions->where('code', 'loading')->first()) {
                $buttons['loading'] = '📦 Залучення до активності';
            }
            if ($permissions->where('code', 'vote')->first()) {
                $buttons['vote'] = 'Голосування';
            }
            if ($permissions->where('code', 'advertisement')->first()) {
                $buttons['advertisement'] = '📣 Важливе оголошення';
            }
            if ($permissions->where('code', 'media')->first()) {
                $buttons['media'] = 'Завантажити медіа';
            }
        }

        $buttons['exit'] = 'Вийти';
        $i = 0;
        foreach ($buttons as $key => $item) {
            $index = (string) floor($i / 2);
            $result[$index][$key] = $item;
            $i++;
        }

        return $result;
    }
}
