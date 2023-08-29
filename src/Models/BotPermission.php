<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function botRoles()
    {
        return $this->belongsToMany(BotRole::class);
    }
}
