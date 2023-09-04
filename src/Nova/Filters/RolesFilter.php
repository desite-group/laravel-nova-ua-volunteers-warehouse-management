<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Nova\Filters;

use DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models\BotRole;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class RolesFilter extends BooleanFilter
{
    public function name()
    {
        return __('Roles');
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
        $values = [];
        foreach ($value as $role_id => $chacked) {
            if ($chacked) {
                $values[] = $role_id;
            }
        }
        if (!empty($values)) {
            return $query->whereIn('role_id', $values);
        }

        return $query;
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function options(Request $request)
    {
        return BotRole::pluck('id', 'name')->toArray();
    }
}
