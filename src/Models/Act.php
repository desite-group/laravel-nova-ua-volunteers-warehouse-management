<?php

namespace DesiteGroup\LaravelNovaWarehouseManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Act extends Model implements Sortable, HasMedia
{
    use HasFactory, InteractsWithMedia, SortableTrait;

    protected $fillable = [
        'title', 'description', 'text', 'article', 'sku', 'category_id', 'price', 'is_active', 'internal_comment'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function counteragent()
    {
        return $this->belongsTo(Counteragent::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
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
        $this->addMediaCollection('photo')->singleFile();
    }
}
