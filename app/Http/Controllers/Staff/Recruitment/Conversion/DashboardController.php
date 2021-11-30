<?php

namespace App\Http\Controllers\Staff\Recruitment\Conversion;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function applicationStatusTracker()
    {
        $live = 0;
        $accepted = 0;
        $pending = 0;

        $data = Application::where('test', 0)->get();

        foreach ($data as $application) {
            switch ($application) {
                case (is_null($application->status) && is_null($application->hired)):
                    $pending++;
                    break;
                case ($application->hired == 1):
                    $live++;
                    break;
                case ($application->status == 1 && $application->hired != 1):
                    $accepted++;
                    break;
            }
        }

        return response()->json(
            [
                $live,
                $accepted,
                $pending,
            ],
            200
        );
    }

    public function averageLiveApplicationConversionTracker()
    {
        $data = Application::where('hired', 1)
            ->where('hire_date', '!=', null)
            ->where('test', 0)
            ->get();

        foreach ($data as $application) {
            $created_at = $application->created_at;

            $hired_at = $application->hire_date;

            $dateDiff = date_diff($created_at, $hired_at);
        }
        return response()->json($dateDiff, 200);
    }

    public function averageAcceptedApplicationConversionTracker()
    {
        $data = Application::where('status', 1)
            ->where('accept_date', '!=', null)
            ->where('hired', null)
            ->where('test', 0)
            ->get();

        foreach ($data as $application) {
            $created_at = $application->created_at;

            $accepted_at = $application->accept_date;

            $dateDiff = date_diff($created_at, $accepted_at);
        }
        return response()->json($dateDiff, 200);
    }
}
