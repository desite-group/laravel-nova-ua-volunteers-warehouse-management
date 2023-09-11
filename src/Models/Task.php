<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Task extends Model
{
    use HasFactory;

    const statuses = [
        'new' => [
            'uk' => 'Нове',
            'en' => 'New'
        ],
        'completed' => [
            'uk' => 'Виконано',
            'en' => 'Completed'
        ],
        'canceled' => [
            'uk' => 'Відмінено',
            'en' => 'Canceled'
        ],
        'later' => [
            'uk' => 'Відкладено',
            'en' => 'Later'
        ]
    ];

    const remainderTypes = [
        'everyday' => [
            'uk' => 'Щодня',
            'en' => 'Щодня'
        ],
        'every_week' => [
            'uk' => 'Щотижня',
            'en' => 'Every week'
        ],
        'every_two_days' => [
            'uk' => 'Кожні 2 дні',
            'en' => 'Every 2 days'
        ],
        'every_three_days' => [
            'uk' => 'Кожні 3 дні',
            'en' => 'Every 3 days'
        ],
        'every_two_week' => [
            'uk' => 'Кожні 2 тижня',
            'en' => 'Every 2 weeks'
        ],
        'every_month' => [
            'uk' => 'Щомісяця',
            'en' => 'Every month'
        ],
        'without' => [
            'uk' => 'Не нагадувати',
            'en' => 'Do not remind'
        ]
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'log' => 'array',
    ];

    protected $fillable = [
        'author_bot_user_id', 'bot_user_id', 'deadline', 'reminder', 'description', 'log', 'is_active', 'is_completed'
    ];

    public static function getReminderTypes(?string $lang = null): array
    {
        if (!$lang) {
            $lang = config('app.locale');
        }

        $types = [];
        foreach (self::remainderTypes as $key => $type) {
            $types[$key] = $type[$lang];
        }
        return $types;
    }

    public static function getReminderTypeByCode(?string $code, ?string $lang = null): string
    {
        if (!$lang) {
            $lang = config('app.locale');
        }
        if (!self::remainderTypes[$code][$lang]) {
            return $lang === 'uk' ? 'Не встановлено' : 'Not selected';
        }


        return self::remainderTypes[$code][$lang];
    }

    public static function getStatusByCode(?string $code, ?string $lang = null): ?string
    {
        if (!$lang) {
            $lang = config('app.locale');
        }

        return self::statuses[$code][$lang] ?? null;
    }

    public function getStatusTitleAttribute()
    {
        return Arr::get(self::statuses, $this->status, '');
    }

    /**
     * Scope a query to only include active tasks.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function scopeCompleted(Builder $query): void
    {
        $query->where('is_completed', 1);
    }

    public function scopeNotCompleted(Builder $query): void
    {
        $query->where('is_completed', 0);
    }

    public function bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }

    public function author_bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }

    public function setNewStatus(string $status, ?string $text = null)
    {
        $log = is_array($this->log) ? $this->log : [];
        $log[] = [
            'datetime' => Carbon::now(),
            'old_status' => $this->status,
            'new_status' => $status,
            'comment' => $text
        ];
        $this->log = $log;
        $this->is_active = ($status == 'completed' || $status == 'canceled') ? 0 : 1;
        $this->is_completed = $status == 'completed' ? 1 : 0;
        $this->status = $this->getAttribute('status');
        $this->save();
    }
}
