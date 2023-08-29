<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Loading extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\Loading::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'description',
    ];

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Bot';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Loading');
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

            DateTime::make(__('Datetime'), 'datetime'),
            Text::make(__('Location'), 'location'),
            Text::make(__('Description'), 'description'),
            BelongsTo::make(__('Author Bot User'), 'author_bot_user', \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotUser::class)
                ->display('username'),
            BelongsToMany::make(__('Bot Users'), 'bot_users', \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotUser::class)
                ->fields(function () {
                    return [
                        Boolean::make(__('Confirmed'), 'is_confirmed'),
                    ];
                })
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
