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
        'new' => 'Нове',
        'completed' => 'Виконано',
        'canceled' => 'Відмінено',
        'later' => 'Відкладено'
    ];

    const remainderTypes = [
        'everyday' => 'Щодня',
        'every_week' => 'Щотижня',
        'every_two_days' => 'Кожні 2 дні',
        'every_three_days' => 'Кожні 3 дні',
        'every_two_week' => 'Кожні 2 тижня',
        'every_month' => 'Щомісяця',
        'without' => 'Не нагадувати'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'log' => 'array',
    ];

    protected $fillable = [
        'author_bot_user_id', 'bot_user_id', 'deadline', 'reminder', 'description', 'log', 'is_active', 'is_completed'
    ];

    public static function getReminderTypes(): array
    {
        return self::remainderTypes;
    }

    public static function getReminderTypeByCode(?string $code): string
    {
        return self::remainderTypes[$code] ?? 'Не встановлено';
    }

    public static function getStatusByCode(?string $code): ?string
    {
        return self::statuses[$code] ?? null;
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
