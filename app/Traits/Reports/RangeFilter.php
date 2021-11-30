<?php

namespace App\Traits\Reports;

use Carbon\Carbon;

trait RangeFilter
{
    public function scopeFilterByDate($query, string $period, $from = null, $to = null)
    {
        switch ($period) {
            case 'daily':
                return $query->visitPeriod(Carbon::now()->startOfDay(), false);
            case 'week-to-date':
                return $query->visitPeriod(Carbon::now()->startOfWeek(), false);
            case 'weekly':
                return $query->visitPeriod(Carbon::now()->startOfDay()->subDays(7), false);
            case 'month-to-date':
                return $query->visitPeriod(Carbon::now()->startOfMonth(), false);
            case 'monthly':
                return $query->visitPeriod(Carbon::now()->startOfDay()->subDays(30), false);
            case 'custom':
                try {
                    $from = Carbon::createFromFormat('Y-m-d', $from)->endOfDay();
                    $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
                    return $query->visitPeriod($from, $to);
                } catch (\Throwable $th) {
                    return Self::range('monthly');
                }
        }
    }
}
