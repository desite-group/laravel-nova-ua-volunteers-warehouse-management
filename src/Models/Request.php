<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Request extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const MILITARY_TYPE = 'military';
    public const ORGANIZATION_TYPE = 'organization';
    public const PHYSICAL_PERSON_TYPE = 'physical_person';

    protected $fillable = [
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function counteragent(): BelongsTo
    {
        return $this->belongsTo(Counteragent::class);
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 800, 800)
            ->performOnCollections('photo');

        $this->addMediaConversion('thumb_main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 20, 20)
            ->performOnCollections('photo');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo');
    }

    public static function getAvailableTypes()
    {
        return [
            self::MILITARY_TYPE => __('Military request'),
            self::ORGANIZATION_TYPE => __('Organization request'),
            self::PHYSICAL_PERSON_TYPE => __('Physical person request'),
        ];
    }

}
