<?php

namespace App\Http\Controllers\Staff\Recruitment\InitialEnquiry;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Application\Invite;
use App\Models\Staff\User\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Converted invites compared to unmodified
     *
     * @return void
     */
    public function inviteConversionPieChart()
    {
        $converted = Invite::where('converted', 1)->count();

        $unmodified = Invite::where('converted', 0)->count();

        $series = [$converted, $unmodified];

        return response()->json($series, 200);
    }

    /**
     * Counts how long it takes for an invite to convert into a completed application
     * Depending on the result the invite will be assigned to a data object
     * Each data object will increment bu 1 each time an invite fits into that category
     *
     * @return void
     */
    public function conversionTimePieChart()
    {

        $one_day = 0;
        $two_day = 0;
        $three_day = 0;
        $multiple = 0;

        $data = Invite::where('converted', 1)->whereHas('application')->get();

        foreach ($data as $invite) {

            $invite_time = $invite->created_at;

            $application = Application::where('invite_token', $invite->token)->first();

            $time_difference = $invite_time->diffInMinutes($application->created_at);

            if ($time_difference <= 1440) {
                $one_day++;
            }
            if ($time_difference > 1440 && $time_difference <= 2880) {
                $two_day++;
            }
            if ($time_difference > 2880 && $time_difference <= 4320) {
                $three_day++;
            }
            if ($time_difference > 4320) {
                $multiple++;
            }
        }
        $labels = ['0-24', '24-48', '48-72', '72+'];

        $series = [$one_day, $two_day, $three_day, $multiple];

        return response()->json($series, 200);
    }

    /**
     * Referrals counter
     *
     * @return void
     */
    public function referralLeaderboard()
    {
        $data = Invite::whereNotNull('referred_by')->select('referred_by', 'referred_by as username', DB::raw("COUNT(*) as referral_count"))
            ->groupBy('referred_by')
            ->get();
        return $data;
    }
}
