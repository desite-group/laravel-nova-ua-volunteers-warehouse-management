<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotRole;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class IsActiveFilter extends Filter
{
    public function name()
    {
        return __('Is active');
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
        return $query->where('is_active', $value);
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
            'Активний' => 1,
            'Не активний' => 0
        ];
    }
}
