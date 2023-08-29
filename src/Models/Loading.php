<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Loading extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_bot_user_id', 'datetime', 'location', 'description'
    ];

    protected $casts = [
        'datetime' => 'datetime'
    ];

    public function author_bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }

    /**
     * The roles that belong to the user.
     */
    public function bot_users(): BelongsToMany
    {
        return $this->belongsToMany(BotUser::class)->withPivot('is_confirmed');
    }
}
