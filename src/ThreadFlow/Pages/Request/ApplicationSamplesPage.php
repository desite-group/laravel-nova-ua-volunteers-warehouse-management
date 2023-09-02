<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application;
use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\FileOutgoingMessage;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ApplicationSamplesPage extends AbstractPage
{
    protected $data;
    protected function show()
    {
        $type = Application::getTypeByCode($this->data['type']);
        $file = Application::getFileLinkByCode($this->data['type']);
        if ($this->data['type'] === 'person') {
            $messageArray = [
                "Вам буде надіслано файл шаблон для звернення від {$type}",
                "На останньому кроці вам потрібно буде завантажити підписаний документ.\n",
                "Завантажне, роздрукуйте або напишіть від руки та поставте свій підпис.\n",
                "УВАГА! Звернення без прикріпленого підписаного файлу розглядатись не будуть.",
                "Дякуємо за розуміння."
            ];
        } else {
            $messageArray = [
                "Вам буде надіслано файл шаблон для звернення від {$type}",
                "На останньому кроці вам потрібно буде завантажити підписаний документ.\n",
                "Завантажне, заповніть даний шаблон, роздрукуйте, поставте підпис та печатку.\n",
                "УВАГА! Документ вважається дійсним за наявності в ньому ПІДПИСУ і ПЕЧАТКИ.",
                "Звернення без прикріпленого підписаного файлу розглядатись не будуть.",
                "Дякуємо за розуміння."
            ];
        }

        FileOutgoingMessage::makeFromPath(resource_path($file['file']), $type)->reply();

        TextOutgoingMessage::make(
            "Також ви можете відкрити це зверення за посиланням Google Dock " . $file['google_dock']
        )->reply();

        return $this->next(RecipientPage::class, ['data' => $this->data])->withBreadcrumbs();
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->back(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
        }

        return $this->next(RecipientPage::class, ['data' => $this->data])->withBreadcrumbs();
    }
}
