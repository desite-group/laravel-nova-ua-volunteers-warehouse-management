<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogBotMessage extends Model
{
    protected $fillable = [
        'bot_user_id', 'message', 'page_class'
    ];

    use HasFactory;

    public function bot_user()
    {
        return $this->belongsTo(BotUser::class);
    }
}
