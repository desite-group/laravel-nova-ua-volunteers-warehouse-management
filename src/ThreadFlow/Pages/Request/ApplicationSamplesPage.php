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
        $type = Application::getTypeByCode($this->data['type'], $this->session()->get('lang'));
        $file = Application::getFileLinkByCode($this->data['type']);
        if ($this->data['type'] === 'person') {
            $messageArray = [
                __("You will be sent a file with a template for an appeal from") . ' ' . $type,
                __("At the last step, you will need to upload a signed document") . ".\n",
                __("Download, print or handwrite and sign the form") . ".\n",
                __("ATTENTION! Applications without the attached signed file will not be considered."),
                __("ATTENTION! By submitting your data, you agree that we will store and process all personal data provided by you."),
                __("Thanks for your understanding.")
            ];
        } else {
            $messageArray = [
                __("You will be sent a file with a template for an appeal from") . ' ' . $type,
                __("At the last step, you will need to upload a signed document") . ".\n",
                __("Download, fill out this template, print, sign and stamp") . "\n",
                __("ATTENTION! The document is considered valid if it contains a SIGNATURE and a SEAL."),
                __("ATTENTION! By submitting your data, you agree that we will store and process all personal data provided by you."),
                __("Applications without an attached signed file will not be considered."),
                __("Thanks for your understanding.")
            ];
        }

        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        FileOutgoingMessage::makeFromPath(resource_path($file['file']), $type)->reply();

        TextOutgoingMessage::make(
            __("You can also open this application at the Google Dock link") . ' ' . $file['google_dock']
        )->reply();

        return $this->next(RecipientPage::class, ['data' => $this->data]);
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('back')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request\IndexPage::class);
        }

        return $this->next(RecipientPage::class, ['data' => $this->data]);
    }
}
