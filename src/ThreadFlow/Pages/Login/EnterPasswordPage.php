<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage;
use SequentSoft\ThreadFlow\Contracts\Chat\ParticipantInterface;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class EnterPasswordPage extends AbstractPage
{
    private $botUser = null;
    protected $login;

    protected function show()
    {
        $this->reply(new TextOutgoingMessage("Для продовження, введіть пароль який ви вказали при реєстрації\n".
            "якщо це ваша перша авторизація, придумайте пароль та введіть його для продовдження реєстрації", [
            ['back' => __('Back')]
        ]));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(IndexPage::class);
        }

        if (!empty($message->getText())) {
            $password = $message->getText();
            $login = $this->login;

            if ($this->validatePassword($password)) {
                $participant = $message->getContext()->getParticipant();

                if ($this->validateUserForAuth($participant->getId())) {
                    if ($this->auth($participant->getId(), $login, $password)) {
                        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
                    }

                    return $this->next(IndexPage::class);
                }

                if ($this->register($participant, $login, $password)) {
                    return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
                }
                return $this->next(IndexPage::class);
            }

            $this->reply(
                new TextOutgoingMessage('Не вірний формат пароля, будь ласка спробуйте інший.', [
                    ['back' => 'Back'],
                ])
            );
        }

        $this->show();
    }

    private function validatePassword(string $password)
    {
        return true;
    }

    private function validateUserForAuth(string $userId)
    {
        $this->botUser = BotUser::where('bot_user_id', $userId)->first();

        if (!$this->botUser || empty($this->botUser->password)) {
            return false;
        }

        return true;
    }

    private function register(ParticipantInterface $participant, string $login, string $password)
    {
        $userData = [
            'bot_user_id' => $participant->getId(),
            'username' => $participant->getUsername(),
            'first_name' => $participant->getFirstName(),
            'last_name' => $participant->getLastName(),
            'phone' => $login,
            'password' => bcrypt($password),
            'language_code' => $participant->getLanguage(),
            'photo_url' => $participant->getPhotoUrl(),
            'is_active' => 1,
            'is_volunteer' => 1
        ];

        if ($botUser = BotUser::createFromBot($userData)) {
            $this->reply(new TextOutgoingMessage("Дякуємо. Реєстрація успішна"));

            $this->session()->set('user_id', $botUser->id);
            return true;
        } else {
            $this->reply(new TextOutgoingMessage('Вибачте, ви не можете зареєструватись за цими даними.'));
        }
    }

    private function auth(string $userId, string $login, string $password)
    {
        $botUser = BotUser::where('phone', $login)->where('is_active', 1)->first();

        if ($botUser && password_verify($password, $botUser->password)) {
            $this->reply(new TextOutgoingMessage('Авторизація успішна.'));
            $this->session()->set('user_id', $botUser->id);
            return true;
        }

        BotUser::where('bot_user_id', $userId)->update(['is_active' => 0]);
        $this->reply(new TextOutgoingMessage("Дані введено не вірно. Користувач деактивований.\n".
            'Будь ласка, зверніться до ІТ відділу ГО "ВПУ" для активації.'));
        return false;
    }
}
