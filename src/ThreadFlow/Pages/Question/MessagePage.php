<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Question;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Jobs\BotSendNotification;
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
        TextOutgoingMessage::make(__("Please write the text of your question, suggestion or complaint."), [
            Button::text(__('Back'), 'back')
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

        $messageArray = [
            'Створено нове запитання',
            'Автор: ' . $botUser->username,
            'Нікнейм: ' . $botUser->first_name .' '. $botUser->last_name,
            'Телефон: ' . $question->phone,
            'Коментар' . "\n",
            $question->message
        ];
        BotSendNotification::dispatch(implode("\n", $messageArray), [], ['board']);

        TextOutgoingMessage::make(__("Thank you, your message has been saved. You will receive a reply shortly."))->reply();
        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }
}
