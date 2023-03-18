<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\MeasurementUnit;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\CustomsDeclaration as ModelCustomsDeclaration;

class CustomsDeclaration extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ModelCustomsDeclaration::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
        return __('Customs Declaration');
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
            BelongsTo::make(__('Name the person making the declaration'), 'declarationPerson', Counteragent::class),
            BelongsTo::make(__('Driver'), 'driver', Counteragent::class),
            Text::make(__('Brand of car'), 'brand_of_car'),
            Text::make(__('Licence plate'), 'licence_plate'),
            Text::make(__('Dispatcher'), 'dispatcher'),
            Text::make(__('Recipient'), 'recipient')
                ->suggestions(ModelCustomsDeclaration::getMostPopular('recipient', 5)),

            Text::make(__('Place of unloading of goods'), 'place_of_unloading')
                ->suggestions(ModelCustomsDeclaration::getMostPopular('place_of_unloading', 5)),

            BelongsTo::make(__('Checkpoint'), 'checkpoint', Checkpoint::class),

            Date::make(__('Date'), 'date'),

            BelongsToMany::make('Products')
                ->fields(function ($request, $relatedModel) {
                    $measurementUnits = MeasurementUnit::all()
                        ->pluck('name','id')->toArray();
                    return [
                        Text::make(__('Quantity'), 'quantity'),
                        Select::make(__('Volume/boxes'), 'measurement_unit_id')
                            ->options($measurementUnits)
                            ->displayUsing(function ($value) {
                                $measurementUnit = MeasurementUnit::find($value);
                                return optional($measurementUnit)->name ?? '';
                            }),
                    ];
                }),
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
