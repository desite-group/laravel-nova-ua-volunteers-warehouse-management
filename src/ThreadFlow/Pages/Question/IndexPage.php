<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Question;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make('Для початку натисніть відправити контакт', [
            Button::contact('Відправити контакт', 'contact'),
            Button::text('Назад', 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isContact() && !empty($message->getPhoneNumber())) {
            $phoneNumber = $message->getPhoneNumber();
            if ($this->validatePhoneNumber($phoneNumber)) {
                TextOutgoingMessage::make('Дякуємо, ваш контакт отримано.')->reply();
                $participant = $message->getContext()->getParticipant();

                $botUser = BotUser::where('bot_user_id', $participant->getId())->first();
                if (!$botUser) {
                    $userData = [
                        'bot_user_id' => $participant->getId(),
                        'username' => $participant->getUsername(),
                        'first_name' => $participant->getFirstName(),
                        'last_name' => $participant->getLastName(),
                        'phone' => $phoneNumber,
                        'language_code' => $participant->getLanguage(),
                        'photo_url' => $participant->getPhotoUrl(),
                        'is_active' => 1,
                        'is_volunteer' => 0
                    ];

                    $botUser = BotUser::createFromBot($userData);
                }

                return $this->next(MessagePage::class, ['phone' => $phoneNumber, 'bot_id' => $botUser->id])->withBreadcrumbs();
            }
        } else {
            TextOutgoingMessage::make('Вибачте, для продовження потрібно відправити контакт.')->reply();
        }

        $this->show();
    }

    private function validatePhoneNumber(string $phoneNumber): bool
    {
        return true;
    }
}
