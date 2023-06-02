<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use App\Nova\Resource;
use Carbon\Carbon;
use DigitalCreative\ConditionalContainer\ConditionalContainer;
use DigitalCreative\ConditionalContainer\HasConditionalContainer;
use Ebess\AdvancedNovaMediaLibrary\Fields\Images;
use DigitalCreative\JsonWrapper\JsonWrapper;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use \Illuminate\Http\Request as HttpRequest;
use Laravel\Nova\Fields\Select;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\IncomingRequest as RequestModel;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class IncomingRequest extends Resource
{
    use HasConditionalContainer; // Important!
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\IncomingRequest::class;

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
        return __('Request');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(HttpRequest $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),

            Images::make(__('Photo'), 'photo')
                ->conversionOnIndexView('main'),

            BelongsTo::make(__('Counteragent'), 'counteragent', Counteragent::class),

            Select::make(__('Request type'), 'type')->options(
                RequestModel::getAvailableTypes()
            )->displayUsingLabels(),
            ConditionalContainer::make([
                JsonWrapper::make('data', [
                    Textarea::make(__('Description'), 'description')
                ]),
            ])->if('type === ' . RequestModel::MILITARY_TYPE),
            ConditionalContainer::make([
                JsonWrapper::make('data', [
                    Textarea::make(__('Description'), 'description')
                ]),
            ])->if('type === ' . RequestModel::ORGANIZATION_TYPE),
            ConditionalContainer::make([
                JsonWrapper::make('data', [
                    Text::make(__('Country'), 'country'),
                    Text::make(__('Passport ID'), 'passport_id'),
                    Text::make(__('Issued by'), 'issued_by'),
                    Date::make(__('Date of issue'), 'date_of_issue')
                        ->resolveUsing(function ($date) {
                            return Carbon::parse($date)->format('Y-m-d');
                        }),
                    Textarea::make(__('Who is needed'), 'who_is_needed')->rows(2),
                    Textarea::make(__('Description'), 'description')
                ]),
            ])->if('type === ' . RequestModel::PHYSICAL_PERSON_TYPE),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(HttpRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(HttpRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(HttpRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(HttpRequest $request)
    {
        return [];
    }
}
