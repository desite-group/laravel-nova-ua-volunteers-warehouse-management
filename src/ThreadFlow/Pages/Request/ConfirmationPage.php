<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Request;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ConfirmationPage extends AbstractPage
{
    protected function show()
    {
        TextOutgoingMessage::make("Дякуємо, ваше звернення отримано. Ми зв'яжемось з вами найближчим часом.")->reply();

        $messageArray = [
            "Громадська Організація \"Волонтерська Підтримка України\" працює з перших днів війни, для забезпечення потреб: військових, лікарень та простих людей, які потребують допомоги.",
            "Для отримання допомоги від нашої організації просимо виконати всі пункти УМОВ СПІВПРАЦІ.\n",

            "1. ЗВЕРНЕННЯ",
            "Для отримання допомоги першочергово потрібно надіслати нам фото запиту з підписом та печаткою (якщо використовується). Оригінал документу потрібно буде відправити нам через Нову Пошту чи Укрпошту.\n",

            "2. ЗВОРОТНІЙ ЗВ’ЯЗОК",
            "При отриманні допомоги, разом із вантажем, Вам надійде акт прийому-передачі. Його потрібно підписати, поставити печатку (якщо використовується) та надіслати підписаний документ нам через Нову Пошту чи Укрпошту. Можна однією відправкою разом з оригіналом звернення.\n",

            "3. ФОТОЗВІТ",
            "Очікуємо фото використання або видачі ліків/медичних товарів, фото з лікарями/пацієнтами/військовими. При необхідності обличчя та місцевість можуть бути затертими. Фото лише коробок нам не підходять для звітності перед спонсорами.\n",

            "4. ВІДЕОЗВІТ",
            "Відео може бути зняте в момент використання чи роздачі отриманої гуманітарної допомоги. Також можете зазначити наскільки корисним був отриманий вантаж. Такий звіт надзвичайно полюбляють наші іноземні друзі-волонтери."
        ];
        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        $messageArray = [
            "Чому ми вимушені ставити такі умови?",
            "Це все необхідно для наших спонсорів, щоб вони бачили, що допомога дійсно надійшла до тих, хто її потребує. В такому випадку, меценати впевнені у нашій доброчесності та продовжують надсилати нам допомогу, а ми передаємо її Вам.",
            "Отримуючи допомогу ви маєте розуміти скільки людей і праці стоїть за цим. Тому наперед вдячні за розуміння.  Разом до перемоги."
        ];
        TextOutgoingMessage::make(implode("\n", $messageArray))->reply();

        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\IndexPage::class);
    }
}
