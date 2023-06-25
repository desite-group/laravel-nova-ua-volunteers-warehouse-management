<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Database\Factories\CategoryFactory;
use Database\Factories\CustomsDeclaraionsFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CustomsDeclaration extends Model
{
    use HasFactory;

    protected $fillable = [
        'declaration_person_id',
        'driver_id',
        'brand_of_car',
        'licence_plate',
        'dispatcher',
        'recipient',
        'place_of_unloading',
        'checkpoint_id',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function declarationPerson(): BelongsTo
    {
        return $this->belongsTo(Counteragent::class, 'declaration_person_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Counteragent::class, 'driver_id');
    }

    public function checkpoint(): BelongsTo
    {
        return $this->belongsTo(Checkpoint::class, 'checkpoint_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'quantity', 'measurement_unit_id'
            ]);
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return CustomsDeclaraionsFactory::new();
    }

    public static function getMostPopular(string $field, $count)
    {
       return self::orderBy($field, 'desc')->take($count)->get()
            ->pluck($field)
            ->toArray();
    }
}
