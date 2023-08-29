<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone', 'message', 'bot_user_id'
    ];

    public function bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }
}
