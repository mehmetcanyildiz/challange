<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class AppFilter extends Filter
{
    /**
     * Filter the app by the given name.
     *
     * @param string|null $value
     * @return Builder
     */
    public function name(string $value = null): Builder
    {
        return $this->builder->where('name', 'like', "{$value}%");
    }

    /**
     * Filter the app by the given callback.
     *
     * @param string|null $value
     * @return Builder
     */
    public function callback(string $value = null): Builder
    {
        return $this->builder->where('callback', 'like', "{$value}%");
    }

    /**
     * Sort the app by the given order and field.
     *
     * @param array $value
     * @return Builder
     */
    public function sort(array $value = []): Builder
    {
        if (isset($value['by']) && !Schema::hasColumn('apps', $value['by'])) {
            return $this->builder;
        }

        return $this->builder->orderBy(
            $value['by'] ?? 'created_at', $value['order'] ?? 'desc'
        );
    }
}