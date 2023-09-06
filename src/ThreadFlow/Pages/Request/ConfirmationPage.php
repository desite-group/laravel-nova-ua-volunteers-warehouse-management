<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make(__("Thank you, your request has been received. We will get back to you shortly."))->reply();

        $messageArray = [
            __("Non-profit Organization \"Volunteer Support of Ukraine\" has been working since the first days of the war to meet the needs of the military, hospitals and ordinary people in need of assistance."),
            __("In order to receive the help from our organisation, please complete all the points of the TERMS OF COOPERATION") . "\n",

            __("1. APPLICATION"),
            __("To receive assistance, you first need to send us a photo of the request with your signature and stamp (if used). The original document will need to be sent to us via Nova Poshta or Ukrposhta") . "\n",

            __("2. COMMUNICATION"),
            __("After receiving the aid, you will receive an acceptance certificate along with the cargo. It must be signed, stamped (if used) and sent to us via Nova Poshta or Ukrposhta. It can be sent in one shipment together with the original application") . "\n",

            __("3. PHOTO RAPPORT"),
            __("We expect photos of the use or delivery of medicines/medical supplies, photos with doctors/patients/military personnel. If necessary, faces and areas can be blurred. Photos of just boxes are not suitable for reporting to sponsors") . "\n",

            __("4. VIDEO REPORT"),
            __("The video can be shot at the moment of use or distribution of the received humanitarian aid. You can also note how useful the received cargo was. This kind of report is extremely popular with our foreign volunteer friends.")
        ];
        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        $messageArray = [
            __("Why do we have to set such standards?"),
            __("This is all necessary for our sponsors to see that the aid has actually reached those who need it. In this case, the sponsors are confident in our integrity and continue to send us help, and we pass it on to you."),
            __("When you receive help, you should understand how many people and work are behind it. Therefore, we are grateful for your understanding in advance. Together to victory.")
        ];
        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }
}
