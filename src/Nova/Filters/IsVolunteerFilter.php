<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotRole;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class IsVolunteerFilter extends Filter
{
    public function name()
    {
        return __('Is volunteer');
    }

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->where('is_volunteer', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Волонтер' => 1,
            'Не волонтер' => 0
        ];
    }
}
