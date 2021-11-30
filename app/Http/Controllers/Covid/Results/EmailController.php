<?php

namespace App\Http\Controllers\Covid\Results;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Clinical\ClinicalStaff;
use App\Models\Staff\Covid\Results;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    const LIVE = true; // change to TRUE before commit
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function covid_test_upload_reminder_manual($id)
    {
        $applicant = Application::where('id', $id)->where('hired', 1)->get();
        echo count($applicant) . "\n";
        foreach ($applicant as $staff) {
            $mail = [
                'name' => $staff->first_name,
                'to' => $staff->email,
                'last_name' => $staff->last_name,
                'unique_pin_number' => $staff->id,
                'token' => $staff->token,
            ];
            Mail::send('mail.staff.covid.reminder', $mail, function ($message) use ($mail) {
                $message->from('admin@cavalrycare.co.uk');
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Covid-19 test upload reminder');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Covid-19 test upload reminder');
                }
            });
            return response()->json(['message' => 'Reminder sent'], 200);
        };
    }

    public function covid_test_upload_reminder()
    {
        $portal_ids = ClinicalStaff::where('contacted', 1)->get();
        echo count($portal_ids) . "\n";
        foreach ($portal_ids as $staff) {
            $results = Results::where('staff_id', $staff->staff_id)->count();
            if ($results == 0) {
                $application = Application::where('id', $staff->staff_id)->select('first_name', 'last_name', 'email', 'token')->first();
                $mail = [
                    'name' => $application->first_name,
                    'to' => $application->email,
                    'last_name' => $application->last_name,
                    'unique_pin_number' => $staff->staff_id,
                    'token' => $application->token,
                ];
                try {
                    Mail::send('mail.staff.covid.reminder', $mail, function ($message) use ($mail) {
                        $message->from('admin@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Covid-19 reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Covid-19 reminder');
                        }
                    });
                } catch (\Exception $e) {
                }
            }
            $staff->increment('covid_reminders');
            $staff->save();
        }
    }
}
