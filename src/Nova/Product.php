<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Nova;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;
use NumaxLab\NovaCKEditor5Classic\CKEditor5Classic;
use OptimistDigital\NovaSortable\Traits\HasSortableRows;
use \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Product as ProductModel;

class Product extends WarehouseResource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ProductModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Volunteers Warehouse';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Product');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Images::make(__('Photo'), 'photo')
                ->conversionOnIndexView('main'),

            Text::make(__('Title'), 'title'),

            CKEditor5Classic::make(__('Description'), 'description')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
                })
                ->hideFromIndex(),

            CKEditor5Classic::make(__('Full description'), 'text')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
                })
                ->hideFromIndex(),

            Text::make('Артикул', 'article')
                ->rules('max:255')
                ->hideFromIndex()
                ->creationRules(['nullable', 'unique:products'])
                ->updateRules('unique:products,article,{{resourceId}}|required'),

            BelongsTo::make(__('Category'), 'category', Category::class)
                ->display('title'),

            Number::make(__('Purchase price'), 'purchase_price')
                ->step(0.01)
                ->sortable(),

            Number::make(__('Price'), 'price')
                ->step(0.01)
                ->sortable(),

            CKEditor5Classic::make(__('Internal comment'), 'internal_comment')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
                }),

            Boolean::make(__('Active'), 'is_active'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
