<?php

namespace Database\Seeders;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotPermission;
use Illuminate\Database\Seeder;

class VolunteersWarehouseBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedCustomsCheckpoints();
        $this->seedMeasurementUnits();
        $this->seedPermissions();
        $this->seedBotRoles();
    }

    private function seedMeasurementUnits()
    {
        $units = [
            [
                'name' => 'кілограм',
                'description' => '',
                'code' => 'кг',
                'is_active' => 1,
                'is_general' => 1,
            ],
            [
                'name' => 'штука',
                'description' => '',
                'code' => 'шт',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'упаковка',
                'description' => 'упаковка вміщає дeкілька штук',
                'code' => 'уп',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'ящик',
                'description' => 'ящик вміщає дeкілька упаковок',
                'code' => 'ящ',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'метр',
                'description' => '',
                'code' => 'м',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'пара',
                'description' => 'відноситься до взуття, одягу, тощо.',
                'code' => 'пара',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'літр',
                'description' => '',
                'code' => 'л',
                'is_active' => 1,
                'is_general' => 0,
            ],
            [
                'name' => 'пластинка',
                'description' => 'відноситься до медичних препаратів',
                'code' => 'пласт',
                'is_active' => 1,
                'is_general' => 0,
            ],
        ];

        foreach ($units as $unit) {
            \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\MeasurementUnit::firstOrCreate([
                'code' => $unit['code']
            ], $unit);
        }
    }
    private function seedCustomsCheckpoints()
    {
        $customs = [
            'Рава-Руська (Хребенне)',
            'Шегині (Медика)',
            'Ягодин (Дорогуськ)',
            'Устилуг (Зосін)',
            'Краківець (Корчова)',
            'Смільниця (Кросьценко)',
            'Грушів (Будомєж)',
            'Угринів (Долгобичув)',
            'Рава-Руська (Верхрата)',
            'Хирів (Кросьценко)',
            'Володимир-Волинський (Хрубешув)',
            'Мостиська (Пшемисль)',
            'Малий Березний (Убля)',
            'Ужгород (Вишнє-Нємецьке)',
            'Павлове (Матьовце)',
            'Чоп (Страж) (Чієрна над Тисою)',
            'Малі Селменці (Вельке Слеменце)',
            'Дзвінкове (Лонья)',
            'Косино (Барабаш)',
            'Вилок (Тісабеч)',
            'Чоп (Тиса, Захонь)',
            'Лужанка (Берегшурань)',
            'Чоп (Дружба, Захонь)',
            'Саловка (Еперєшке)',
            'Дякове (Халмеу)',
            'Солотвино (Сігету Мармацієй)',
            'Порубне (Сірет)',
            'Ізмаїл (Плаур',
            'Вилкове (Переправа)',
            'Кілія (Кілія Веке)',
            'Тересва (Кимпулунг ла Тиса)',
            'Ділове (Валя Вишеулуй)',
            'Вадул-Сірет (Вікшани)',
            'Орлівка (Ісакча)',
            'Подвір’ївка (Липкань)',
            'Зелена (Медвеже)',
            'Вашківці (Гріменкеуць)',
            'Сокиряни (Клокушна)',
            'Сокиряни (Окниця)',
            'Велика Косниця (Хрушка)',
            'Грабарівка (Окниця)',
            'Болган (Хрістова)',
            'Студена (Ротар)',
            'Олексіївка (Валя Туркулуй)',
            'Шершенці (Валя Туркулуй)',
            'Домниця (Ковбасна)',
            'Тимкове (Броштень)',
            'Станіславка (Веренкеу)',
            'Федосіївка (Жура)',
            'Дубове (Дубеу)',
            'Платонове (Гоянул Ноу)',
            'Йосипівка (Колосово)',
            'Павлівка (Мочарівка)',
            'Великоплоське (Мелеєшть)',
            'Слов‘яносербка (Ближній Хутір)',
            'Гребеники (Тирасполь)',
            'Розалівка (Фрунзе (Нове))',
            'Кучурган (Первомайськ)',
            'Градинці (Незавертайлівка)',
            'Лісне (Сеіць)',
            'Серпневе 1 (Басараб‘яска)',
            'Малоярославець 1 (Чадир-Лунга)',
            'Нові Трояни (Чадир-Лунга)',
            'Залізничне (Кайраклія)',
            'Табаки (Мирне)',
            'Виноградівка (Вулкенєшть)',
            'Долинське (Чишмікіой)',
            'Бронниця (Унгри)',
            'Мамалига (Крива)',
            'Кельменці (Ларга)',
            'Россошани (Брічень)',
            'Паланка (Маяки –Удобне) (Паланка)',
            'Старокозаче (Тудора)',
            'Рені (Джюрджюлешть)',
            'Могилів-Подільський (Отач)',
            'Цекинівка (Сорока)',
            'Ямпіль (Косеуць)',
            'Цекинівка (Сорока)',
            'Велика Косниця (Василькеу)',
            'Слобідка (Ковбасна)',
            'Кучурган (Новосавицьке)',
            'Фрікацей (Етулія)',
            'Рені (Джюрджюлешть)',
            'Могилів-Подільський (Волчинець)'
        ];

        foreach ($customs as $custom) {
            \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Checkpoint::firstOrCreate([
                'name' => $custom
            ]);
        }
    }

    private function seedPermissions()
    {
        $data = [
            [
                'name' => 'Менеджер завдань',
                'code' => 'task',
            ],
            [
                'name' => 'Скарги та пропозиції',
                'code' => 'appeal',
            ],
            [
                'name' => 'Створення завдання іншим',
                'code' => 'task-creating',
            ],
            [
                'name' => 'Завантаження/Розвантаження',
                'code' => 'loading',
            ],
            [
                'name' => 'Важливе оголошення',
                'code' => 'advertisement',
            ],
            [
                'name' => 'Медіа',
                'code' => 'media',
            ],
            [
                'name' => 'Робота з складом',
                'code' => 'warehouse',
            ],
            [
                'name' => 'Робота з документами',
                'code' => 'documents',
            ],
            [
                'name' => 'Голосування',
                'code' => 'vote',
            ]
        ];

        foreach ($data as $item) {
            \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotPermission::firstOrCreate(['code' => \Illuminate\Support\Arr::get($item, 'code')], $item);
        }
    }

    private function seedBotRoles()
    {
        $roles = [
            [
                'name'          => 'Гість',
                'code'          => 'guest'
            ],
            [
                'name'          => 'Волонтер',
                'code'          => 'volunteer'
            ],
            [
                'name'          => 'Активний Волонтер',
                'code'          => 'active-volunteer'
            ],
            [
                'name'          => 'Медіа',
                'code'          => 'media'
            ],
            [
                'name'          => 'Опрацювання Звернень',
                'code'          => 'applications'
            ],
            [
                'name'          => 'Робота з складом',
                'code'          => 'warehouse'
            ],
            [
                'name'          => 'Робота з документами',
                'code'          => 'documents'
            ],
            [
                'name'          => 'Правління',
                'code'          => 'board'
            ],
        ];

        foreach ($roles as $role) {
            $role = \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotRole::firstOrCreate(['code' => \Illuminate\Support\Arr::get($role, 'code')], $role);

            switch ($role->code) {
                case 'guest':
                    $role->permissions()->attach([1,2]);
                    break;
                case 'volunteer':
                    $role->permissions()->attach([1,2,3,4]);
                    break;
                case 'active-volunteer':
                    $role->permissions()->attach([1,2,3,4,5]);
                    break;
                case 'media':
                    $role->permissions()->attach([1,2,3,4,5,6]);
                    break;
                case 'applications':
                    $role->permissions()->attach([1,2,3,4,5,6]);
                    break;
                case 'warehouse':
                    $role->permissions()->attach([1,2,3,4,5,6,7]);
                    break;
                case 'documents':
                    $role->permissions()->attach([1,2,3,4,5,6,7,8]);
                    break;
                case 'board':
                    foreach (BotPermission::all() as $permission) {
                        $role->permissions()->attach($permission->id);
                    }
                    break;
            }
        }
    }
}
