<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Database\Factories\ApplicationsFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Application extends Model implements Sortable, HasMedia
{
    use HasFactory, InteractsWithMedia, SortableTrait;

    const types = [
        'military'      => 'Військової Частини',
        'organization'  => 'Організації',
        'person'        => 'фізичної особи (у т.ч. військовослужбовця)'
    ];

    const links = [
        'military'      => [
            'google_dock' => 'https://docs.google.com/document/d/1h-NDCGVQLlbk3IIeZpXwdKmbcmjfsuKxKl1TPacyjLs',
            'file' => 'https://docs.google.com/document/d/1h-NDCGVQLlbk3IIeZpXwdKmbcmjfsuKxKl1TPacyjLs'
        ],
        'organization'  => [
            'google_dock' => 'https://docs.google.com/document/d/1lZ_gjlVtiK53INY303xiRyy7oV0PBMq4gVZ5DuPwv8E',
            'file' => 'https://docs.google.com/document/d/1lZ_gjlVtiK53INY303xiRyy7oV0PBMq4gVZ5DuPwv8E'
        ],
        'person'        => [
            'google_dock' => 'https://docs.google.com/document/d/13Wbg4iDUa17k5N48GqZP2qoPvYv6IwhE7z30U3n2Xfo',
            'file' => 'https://docs.google.com/document/d/13Wbg4iDUa17k5N48GqZP2qoPvYv6IwhE7z30U3n2Xfo'
        ]
    ];

    protected $fillable = [
        'document_number', 'organization',
        'organization_address', 'organization_chief_name', 'organization_chief_surname', 'organization_chief_patronymic',
        'phone', 'recipient',
        'additional_text', 'internal_comment', 'type', 'needs'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ApplicationsFactory::new();
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
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

    public static function getTypeByCode(?string $code): ?string
    {
        return self::types[$code] ?? null;
    }

    public static function getFileLinkByCode(?string $code): ?array
    {
        return self::links[$code] ?? null;
    }
}
