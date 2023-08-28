<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use Ebess\AdvancedNovaMediaLibrary\Fields\Files;
use Laravel\Nova\Fields\Select;
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
//use Outl1ne\NovaSortable\Traits\HasSortableRows;
use \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Application as ApplicationModel;

class Application extends WarehouseResource
{
//    use HasSortableRows;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = ApplicationModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'document_number';

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
        return __('Application');
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

            Textarea::make(__('Organization'), 'organization'),
            Text::make(__('Organization Chief Name'), 'organization_chief_name'),
            Text::make(__('Organization Chief Surname'), 'organization_chief_surname'),
            Text::make(__('Organization Chief Patronymic'), 'organization_chief_patronymic'),
            Text::make(__('Organization Address'), 'organization_address'),

            Text::make(__('Recipient'), 'recipient'),
            Text::make(__('Phone'), 'phone'),

            CKEditor5Classic::make(__('Additional Text'), 'additional_text')
                ->displayUsing(function ($value) {
                    return strip_tags($value);
                }),

            Select::make(__('Type'), 'type')->options([
                'organization' => __('Organization'),
                'military_personnel' => __('Military Personnel'),
                'personal' => __('Personal')
            ]),

            Select::make(__('Needs'), 'needs')->options([
                'military' => __('Military'),
                'injured' => __('Injured'),
                'civilian_displaced' => __('Civilian Displaced')
            ]),

            Files::make(__('Documents'), 'documents'),

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
