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
    private $isFileReceived = false;
    protected function show()
    {
        $lang = $this->session()->get('lang');

        $application = Application::where('id', $this->application_id)->firstOrFail();
        $type = Application::getTypeByCode($application->type, $lang);

        if ($application->type === 'person') {
            $messageArray = [
                __("Now you will need to send us a scanned or photographed"),
                __('Request from') . ' ' . $type . ' ' . __('with signature') . "\n",
                __("You will also need to upload a photo of the RNOCPP (individual tax number)"),
                __("You will also need to upload a photo of your passport (pages 1, 2, 3, 11) or an ID card with an application where your residence is indicated"),
                __("A photo of a military ID card or certificate of a combatant"),
                __("Thank you for your understanding.")
            ];
        } else {
            $messageArray = [
                __("Now you will need to send us a scanned or photographed"),
                __('Request from') . ' ' . $type . ' ' . __('with signature and seal') . "\n",
                __("ATTENTION! The document is considered valid if it contains a SIGNATURE and a SEAL."),
                __("Applications without an attached signed file will not be considered."),
                __("Thank you for your understanding.")
            ];
        }

        TextOutgoingMessage::make(implode("\n", $messageArray), [
            Button::text(__('Back'), 'back')
        ])->reply();

        TextOutgoingMessage::make(__("Please send a request file from") . ' ' . $type, [
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

            if (!$this->isFileReceived) {
                TextOutgoingMessage::make(__("Thank you, your file has been received. You can send more, or click the") . ' "' . __('Complete') . '".', [
                    Button::text(__('Complete'), 'finish')
                ])->reply();

                $this->isFileReceived = true;
            }

            return;
        }

        if ($message->isText('finish')) {
            return $this->next(ConfirmationPage::class);
        }

        $this->show();
    }
}
