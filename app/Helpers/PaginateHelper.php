<?php

namespace App\Helpers;

use Illuminate\Database\Query\Builder;

class PaginateHelper
{
    public static function returnDataPaginate(Builder $query): array
    {

        $query = $query->paginate(10);

        return [
            'total' => $query->total(),
            'data' => $query->items(),
        ];
    }
}
