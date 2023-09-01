<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Question;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Question;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\ApplicationUploadPage;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class MessagePage extends AbstractPage
{
    protected $phone;
    protected $bot_id;
    protected function show()
    {
        TextOutgoingMessage::make("Напишіть будь ласка текст вашого запитання, пропозиції чи скарги.", [
            Button::text('Назад', 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        $botUser = BotUser::find($this->bot_id);
        $question = new Question([
            'phone' => $this->phone ?? $botUser->phone,
            'message' => $message->getText()
        ]);
        $botUser->questions()->save($question);

        TextOutgoingMessage::make("Дякуємо, ваше ми отримали ваше звернення. Надішлемо вам відповідь найближчим часом.")->reply();
        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }
}
