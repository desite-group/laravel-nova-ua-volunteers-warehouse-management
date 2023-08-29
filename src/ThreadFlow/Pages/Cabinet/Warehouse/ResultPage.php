<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\Warehouse;

use SequentSoft\ThreadFlow\Contracts\Messages\Incoming\Regular\IncomingRegularMessageInterface;
use SequentSoft\ThreadFlow\Messages\Outgoing\Regular\TextOutgoingMessage;
use SequentSoft\ThreadFlow\Page\AbstractPage;

class ResultPage extends AbstractPage
{
    protected $type;
    protected $text;

    protected $demoData = [
        [
            'name' => 'Starlink',
            'count' => 10,
            'unit_title' => 'шт'
        ],
        [
            'name' => 'Сушкар',
            'count' => 3,
            'unit_title' => 'шт'
        ],
        [
            'name' => 'DJI Mavic 3',
            'count' => 2,
            'unit_title' => 'шт'
        ],
        [
            'name' => 'Вологі серветки',
            'count' => 40,
            'unit_title' => 'ящ'
        ],
        [
            'name' => 'Консерви',
            'count' => 50,
            'unit_title' => 'ящ'
        ],
        [
            'name' => 'Метаклапроміт',
            'count' => 10,
            'unit_title' => 'уп'
        ]
    ];

    protected function show()
    {
        $buttons = [];
        $message = '';
        $count = rand(0,6);
        for ($i = 0; $i < $count; $i++){
            $number = $i+1;
            $message .= "{$number}. {$this->demoData[$i]['name']} - {$this->demoData[$i]['count']} {$this->demoData[$i]['unit_title']}.\n";

            $index = (string) floor($i / 2);
            $buttons[$index][$i] = $this->demoData[$i]['name'];
        }

        $buttons[]['search'] = 'Змінити критерій пошуку';
        $buttons[]['general'] = 'Повернутись у головне меню';

        $this->reply(new TextOutgoingMessage("За вашим критерієм\n".
            $this->text.
            "\n Знайдено записів: {$count}\n\n". $message .
            "\n Натисніть на запис який вас цікавить, або змініть критерій пошуку", $buttons));
    }

    protected function handleMessage(IncomingRegularMessageInterface $message)
    {
        if ($message->isText('search')) {
            return $this->next(SearchPage::class, ['type' => $this->type])->withBreadcrumbs();
        }

        if ($message->isText('general')) {
            return $this->next(\DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\ThreadFlow\Pages\Cabinet\IndexPage::class);
        }

        $this->show();
    }
}
