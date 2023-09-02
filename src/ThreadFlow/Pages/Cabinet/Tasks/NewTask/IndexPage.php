<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Tasks\NewTask;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use Illuminate\Support\Arr;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        $users = $this->getCurrentUsers();
        $buttons = [];

        if ($users) {
            $i = 0;
            foreach ($users as $key => $user) {
                $index = (string) floor($i / 3);
                $buttons[$index][$key] = $user;
                $i++;
            }
            $message = 'Виберіть користувача якому ви хочете створити завдання.';
        } else {
            $message = 'Нажаль на даний момент немає користувачів кому можна створити завдання.';
        }
        $buttons[]['back'] = __('Back');

        $this->reply(new TextOutgoingMessage($message, $buttons));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        return $this->next(CommentPage::class, [
            'user' => [
                'id' => $message->getText(),
                'name' => Arr::get($this->getCurrentUsers(), $message->getText())
            ]])
            ->withBreadcrumbs();
    }

    private function getCurrentUsers()
    {
        $result = [];
        foreach (BotUser::all() as $user){
            $result[$user->id] = $user->fullName;
        }

        return $result;
    }
}
