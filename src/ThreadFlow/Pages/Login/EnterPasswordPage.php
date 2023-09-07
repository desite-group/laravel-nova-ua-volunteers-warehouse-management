<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage;
use SequentSoft\ThreadFlow\Contracts\Chat\ParticipantInterface;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;
use SequentSoft\ThreadFlow\Keyboard\Button;

class EnterPasswordPage extends AbstractPage
{
    private $botUser = null;
    protected $login;
    protected $participant;

    protected function show()
    {
        $messageArray = [
            __("To continue, enter the password you specified during registration")
        ];
        if (!$this->validateUserForAuth($this->participant->getId())) {
            $messageArray = [
                __("The account does not exist yet. To continue registration, create and enter a password"),
                __("Write down this password, it is required for authorisation and cannot be recovered.")
            ];
        }
        $this->reply(new TextOutgoingMessage(implode("\n", $messageArray), [
            Button::text(__('Back'), 'back')
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
                if ($this->validateUserForAuth($this->participant->getId())) {
                    if ($this->auth($this->participant->getId(), $login, $password)) {
                        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
                    }

                    return $this->next(IndexPage::class);
                }

                if ($this->register($this->participant, $login, $password)) {
                    return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
                }
                return $this->next(IndexPage::class);
            }

            $this->reply(
                new TextOutgoingMessage(__('Password format is not valid, please try another one.'), [
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
            $this->reply(new TextOutgoingMessage(__("Thank you. Registration is successful")));

            $this->session()->set('user_id', $botUser->id);
            return true;
        } else {
            $this->reply(new TextOutgoingMessage(__('Sorry, you cannot register with these details.')));
        }
    }

    private function auth(string $userId, string $login, string $password)
    {
        $botUser = BotUser::where('phone', $login)->where('is_active', 1)->first();

        if ($botUser && password_verify($password, $botUser->password)) {
            $this->reply(new TextOutgoingMessage(__('Authorisation is successful.')));
            $this->session()->set('user_id', $botUser->id);
            return true;
        }

        BotUser::where('bot_user_id', $userId)->update(['is_active' => 0]);
        $this->reply(new TextOutgoingMessage(__("Data entered incorrectly. User is deactivated") . "\n".
            __('Please contact the IT department of the NPO \"VPU\" for activation.')));
        return false;
    }
}
