<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Login\LoginPage;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class IndexPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make( __('Welcome to the official bot of the non-profit organization "Volunteers Support Ukraine"') . "\n\n".
            __('Please select the action'), [
            [
                Button::text('📄 '.  __('Leave an application for assistance'), 'request'),
                Button::text( '🍩 ' . __('Our details'), 'details')
            ],
            [
                Button::text(__('🇺🇦 Змінити мову'), 'language'),
                Button::text('📝 ' . __('Write questions or wishes'), 'question')
            ],
            Button::text('🔒 ' . __('Login as a volunteer'), 'login')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('request')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\IndexPage::class)->withBreadcrumbs();
        }

        if ($message->isText('details')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Details\IndexPage::class)->withBreadcrumbs();
        }

        if ($message->isText('question')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Question\IndexPage::class)->withBreadcrumbs();
        }

        if ($message->isText('language')) {
            if (!$this->session()->get('lang') || $this->session()->get('lang') === 'en') {
                $lang = 'uk';
            } else if ($this->session()->get('lang') === 'uk') {
                $lang = 'en';
            } else {
                $lang = 'uk';
            }

            $this->session()->set('lang', $lang);
            app('translator')->setLocale($lang);
        }

        if ($message->isText('login')) {
            return $this->next(LoginPage::class)->withBreadcrumbs();
        }

        $this->show();
    }
}
