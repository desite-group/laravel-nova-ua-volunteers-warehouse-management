<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova;

use App\Nova\Resource;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Actions\BotUserSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Actions\NewVersionSendMessage;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters\IsActiveFilter;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters\IsVolunteerFilter;
use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters\RolesFilter;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class BotUser extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotUser::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'username';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'username',
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
        return 'Користувачі Бота';
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return 'Користувач Бота';
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
            Text::make(__('Bot User Id'), 'bot_user_id')->readonly(),
            Text::make(__('Username'), 'username')->readonly(),
            Text::make(__('First name'), 'first_name'),
            Text::make(__('Last Name'), 'last_name'),
            Text::make(__('Phone'),  'phone'),
            Password::make(__('Password'), 'password')->onlyOnForms(),
            Text::make(__('Language Code'), 'language_code')->readonly(),
            Text::make(__('Photo Url'), 'photo_url')->readonly()->hideFromIndex(),

            Boolean::make(__('Active'), 'is_active'),
            Boolean::make(__('Volunteer'), 'is_volunteer'),
            BelongsTo::make(__('Roles'), 'role', \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\BotRole::class)
                ->singularLabel(__('Role')),

            HasMany::make(__('Bot Log Messages'), 'log_messages', \DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\LogBotMessage::class)
                ->singularLabel(__('Bot Log Message')),
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
        return [
            new RolesFilter(),
            new IsActiveFilter(),
            new IsVolunteerFilter()
        ];
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
        return [
            new BotUserSendMessage(),
            new NewVersionSendMessage()
        ];
    }
}
