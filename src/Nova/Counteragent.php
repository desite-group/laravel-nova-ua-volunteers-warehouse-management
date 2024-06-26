<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use Laravel\Nova\Fields\Trix;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Counteragent as CounteragentModel;

class Counteragent extends WarehouseResource
{
//    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = CounteragentModel::class;

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
        return __('Conteragent');
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

            Text::make(__('Name'), 'name'),
            Text::make(__('Surname'), 'surname'),
            Text::make(__('Patronymic'), 'patronymic'),
            Text::make(__('Phone'), 'phone'),
            Text::make(__('Recipient Organization'), 'recipient_organization'),
            Text::make(__('Recipient Address'), 'recipient_address'),

            Trix::make(__('Internal comment'), 'internal_comment')
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
