<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use Laravel\Nova\Fields\BelongsTo;
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
use \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Act as ActModel;

class Act extends WarehouseResource
{
    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ActModel::class;

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
        return __('Act');
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

            Text::make(__('Document Number'), 'document_number'),

            Text::make(__('Driver Name'), 'driver_name'),
            Text::make(__('Driver Surname'), 'driver_surname'),
            Text::make(__('Driver Patronymic'), 'driver_patronymic'),
            Text::make(__('Car Info'), 'car_info'),
            Text::make(__('License Plate'), 'license_plate'),
            Text::make(__('Recipient Address'), 'recipient_address'),
            Text::make(__('Recipient Organization'), 'recipient_organization'),

            CKEditor5Classic::make(__('Description'), 'description')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
                }),

            Text::make(__('Name'), 'name'),
            Text::make(__('Surname'), 'surname'),
            Text::make(__('Patronymic'), 'patronymic'),
            Text::make(__('Phone'), 'phone'),

            BelongsTo::make(__('Counteragent'), 'counteragent', Counteragent::class),

            BelongsTo::make(__('Application'), 'application', Application::class)
                ->display('title'),

            CKEditor5Classic::make(__('Internal comment'), 'internal_comment')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
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
