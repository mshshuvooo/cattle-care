<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * @param array $params
     * @return Builder
     */
    protected function search(array $params = []): Builder
    {
        return self::where(function ($query) use ($params) {
            if (!empty($params['search'])) {
                foreach (self::$searchable as $field) {
                    $query->orWhere($field, 'LIKE', '%' . $params['search'] . '%');
                }
            }
        });
    }
}
