<?php

namespace App\Services;

use App\Models\Staff\Map\{ApplicantMap as Markers};
use App\Models\Staff\User\User;

class MapService
{
    const CACHE_KEY = "Markers";

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public static function build($filter, $filterBy)
    {
        $filtered = self::filter($filter);
        $filterBy = self::filter_by((clone $filtered), $filterBy);
        return $filterBy->with('application')->get();
    }

    public static function filter($filter)
    {
        switch ($filter) {
            case ('accepted'):
                return Markers::whereHas('application', function ($query) {
                    return $query->where('status', 1)->where('hired', null);
                });
            case ('live'):
                return Markers::whereHas('application', function ($query) {
                    return $query->where('hired', 1);
                });
        }
    }

    public static function filter_by($model, $filterBy)
    {
        if ($filterBy == 'all') {
            return $model;
        }
        return $model->whereHas('application', function ($query) use ($filterBy) {
            return $query->where('position', $filterBy);
        });
    }

    // cache access
    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }
}
