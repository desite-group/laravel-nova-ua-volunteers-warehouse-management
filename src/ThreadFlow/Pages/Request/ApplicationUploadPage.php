<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Keyboard\Button;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ApplicationUploadPage extends AbstractPage
{
    protected $application_id;
    protected function show()
    {
        $lang = $this->session()->get('lang');

        $application = Application::where('id', $this->application_id)->firstOrFail();
        $type = Application::getTypeByCode($application->type, $lang);

        if ($application->type === 'person') {
            $messageArray = [
                "Зараз вам потрібно буде надіслати нам вісканований або сфотографований",
                "Запит від {$type} з підписом\n",
                "Також вам потрібно буде завантажити фото свого паспорта (сторінки 1,2,3, 11), або ID-картка",
                "Для військовослужбовця також обовʼязковим є фото військового квитка або УБД",
                "Дякуємо за розуміння."
            ];
        } else {
            $messageArray = [
                "Зараз вам потрібно буде надіслати нам вісканований або сфотографований",
                "Запит від {$type} з підписом та печаткою\n",
                "УВАГА! Документ вважається дійсним за наявності в ньому ПІДПИСУ і ПЕЧАТКИ.",
                "Звернення без прикріпленого підписаного файлу розглядатись не будуть.",
                "Дякуємо за розуміння."
            ];
        }

        TextOutgoingMessage::make(implode("\n", $messageArray), [
            Button::text(__('Back'), 'back')
        ])->reply();

        TextOutgoingMessage::make("Будь ласка, відправте файл звернення від {$type}", [
            Button::text(__('Back'), 'back')
        ])->reply();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        if ($message->isFile()) {
            $application = Application::where('id', $this->application_id)->first();
            if (!$application) {
                $this->show();

                return;
            }
            $url = $message->getUrl();
            $filename = basename($url);
            $application->addMediaFromUrl($url)->usingName($filename)->toMediaCollection('documents');
            TextOutgoingMessage::make("Дякуємо, ваш файл отримано. Ви можете відправити ще, або натиснути кнопку \"Завершити\".", [
                Button::text('Завершити', 'finish')
            ])->reply();

            return;
        }

        if ($message->isText('finish')) {
            return $this->next(ConfirmationPage::class);
        }

        $this->show();
    }
}
