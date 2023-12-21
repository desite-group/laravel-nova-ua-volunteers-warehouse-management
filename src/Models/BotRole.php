<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code'
    ];

    public function users()
    {
        return $this->hasMany(BotUser::class, 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(BotPermission::class);
    }

    public function getNameWithIdAttribute()
    {
        return $this->id . ' ' . $this->name;
    }
}
