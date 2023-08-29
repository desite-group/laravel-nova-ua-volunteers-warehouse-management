<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Arr;

class BotUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'bot_user_id',
        'username',
        'first_name',
        'last_name',
        'phone',
        'password',
        'language_code',
        'photo_url',
        'is_active',
        'is_volunteer',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(BotRole::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function loadings(): BelongsToMany
    {
        return $this->belongsToMany(Loading::class)->withPivot('is_confirmed');
    }

    public function getFullNameAttribute(): string
    {
        return implode(' ', array_filter([
            optional($this)->first_name,
            optional($this)->last_name
        ]));
    }

    public static function createFromBot(array $data): self
    {
        return self::updateOrCreate([
            'bot_user_id' => Arr::get($data, 'bot_user_id'),
        ],[
            'bot_user_id' => Arr::get($data, 'bot_user_id'),
            'username' => Arr::get($data, 'username'),
            'first_name' => Arr::get($data, 'first_name'),
            'last_name' => Arr::get($data, 'last_name'),
            'phone' => Arr::get($data, 'phone'),
            'password' => Arr::get($data, 'password'),
            'language_code' => Arr::get($data, 'language_code'),
            'photo_url' => Arr::get($data, 'photo_url'),
            'is_active' => Arr::get($data, 'is_active'),
            'is_volunteer' => Arr::get($data, 'is_volunteer', 0)
        ]);
    }
}
