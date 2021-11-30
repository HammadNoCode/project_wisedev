<?php

namespace App\Http\Controllers\Staff\Business\Client;

use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use App\Models\Staff\Business\Client;
use App\Models\Staff\Business\Hours;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function loop_range($timescale)
    {
        switch ($timescale) {
            case 'weekly':
                return [
                    'current' => 12,
                    'last' => [
                        'less_than' => 13,
                        'equal_to' => 24,
                    ],
                    'sub' => 'subWeeks',
                    'format' => 'Y-m-d',
                    'pretty_format_1' => 'd/m',
                    'pretty_format_2' => 'd/m/y',
                    'startOf' => 'startOfWeek'
                ];
                break;
            case 'monthly':
                return [
                    'current' => 12,
                    'last' => [
                        'less_than' => 13,
                        'equal_to' => 24,
                    ],
                    'sub' => 'subMonths',
                    'format' => 'Y-m-d',
                    'pretty_format_1' => 'M',
                    'pretty_format_2' => 'm/Y',
                    'startOf' => 'startOfMonth'
                ];
                break;
            default:
                return $this->loop_range('weekly');
                break;
        }
    }

    public function line_chart_model($model, $range_1, $range_2 = null)
    {
        $model = $model->where('created_at', '>', $range_1);
        if ($range_2) {
            $model = $model->where('created_at', '<=', $range_2);
        }
        return $model;
    }

    public function line_chart_query(Request $request, $id)
    {
        $env = User::where('id', session('staff_id'))->value('test');
        $range = $this->loop_range($request->timescale);
        $data = [];

        $data['name'][0] = 'Requested';
        for ($i = $range['current']; $i >= 1; $i--) {
            $data['units'][] = Carbon::now()->{$range['startOf']}()->{$range['sub']}($i)->format($range['pretty_format_2']);
            $seriesOne = $this->line_chart_model(
                Hours::where('client_id', $id)->where('test', $env),
                Carbon::now()->{$range['startOf']}()->{$range['sub']}($i),
                Carbon::now()->{$range['startOf']}()->{$range['sub']}($i - 1)
            );
            $data['series'][0][] = (int) (clone $seriesOne)->sum('requested_hours');
        }
        $data['name'][1] = 'Provided';
        for ($i = $range['current']; $i >= 1; $i--) {
            $seriesTwo = $this->line_chart_model(
                Hours::where('client_id', $id)->where('test', $env),
                Carbon::now()->{$range['startOf']}()->{$range['sub']}($i),
                Carbon::now()->{$range['startOf']}()->{$range['sub']}($i - 1)
            );
            $data['series'][1][] = (int) (clone $seriesTwo)->sum('provided_hours');
        }
        return response()->json($data, 200);
    }
}
