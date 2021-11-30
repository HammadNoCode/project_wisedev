<?php

namespace App\Http\Controllers\Staff\Recruitment\Application;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Staff\Recruitment\Application;
use App\Services\TextService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReminderController extends Controller
{
    const LIVE = false;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = '07910451712';

    /**
     * Send reminder to applications where created_at is >= 1 week
     *
     * @return void
     */
    public function one_week()
    {
        $contactable = Application::where('declaration', null)
            ->where('created_at', '=', Carbon::now()->subWeek())
            ->where('reminder_count', 2)
            ->whereTest(1)
            ->get();
        return $contactable;
        echo count($contactable) . "\n";
        foreach ($contactable as $applicant) {
            $mail = [
                'name' => $applicant->first_name . ' ' . $applicant->last_name,
                'to' => $applicant->email,
            ];
            try {
                Mail::send('mail.staff.application.reminder', $mail, function ($message) use ($mail) {
                    $message->from('join@cavalrycare.co.uk');
                    if (self::LIVE) {
                        $message->to($mail['to'], $mail['name'])->subject('Application Reminder');
                    } else {
                        $message->to('isaac@warrantywise.co.uk', $mail['name'])->subject('Application Reminder');
                    }
                });
                if (self::LIVE) {
                    TextService::sendSMS($applicant->mobile, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                } else {
                    TextService::sendSMS(self::TEST_MOBILE, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                }
            } catch (\Exception $e) {
            }
            $applicant->update(['reminder_count' => 3]);
        }
    }

    /**
     * Send reminder to applications where created_at is >= 48 hours
     *
     * @return void
     */
    public function two_day()
    {
        $contactable = Application::where('declaration', null)
            ->where('created_at', '=', Carbon::now()->subDays(2))
            ->where('reminder_count', 1)
            ->whereTest(1)
            ->get();
        echo count($contactable) . "\n";
        foreach ($contactable as $applicant) {
            $mail = [
                'name' => $applicant->first_name . ' ' . $applicant->last_name,
                'to' => $applicant->email,
            ];
            try {
                Mail::send('mail.staff.application.reminder', $mail, function ($message) use ($mail) {
                    $message->from('join@cavalrycare.co.uk');
                    if (self::LIVE) {
                        $message->to($mail['to'], $mail['name'])->subject('Application Reminder');
                    } else {
                        $message->to(self::TEST_EMAIL, $mail['name'])->subject('Application Reminder');
                    }
                });
                if (self::LIVE) {
                    TextService::sendSMS($applicant->mobile, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                } else {
                    TextService::sendSMS(self::TEST_MOBILE, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                }
            } catch (\Exception $e) {
            }
            $applicant->update(['reminder_count' => 2]);
        }
    }

    /**
     * Send reminder to applications where created_at is >= 24 hours
     *
     * @return void
     */
    public function one_day()
    {
        $contactable = Application::where('declaration', null)
            ->where('created_at', '=', Carbon::now()->subDay())
            ->where('reminder_count', 0)
            ->whereTest(1)
            ->get();
        return $contactable;
        echo count($contactable) . "\n";
        foreach ($contactable as $applicant) {
            $mail = [
                'name' => $applicant->first_name . ' ' . $applicant->last_name,
                'to' => $applicant->email,
            ];
            try {
                Mail::send('mail.staff.application.reminder', $mail, function ($message) use ($mail) {
                    $message->from('join@cavalrycare.co.uk');
                    if (self::LIVE) {
                        $message->to($mail['to'], $mail['name'])->subject('Application Reminder');
                    } else {
                        $message->to($mail['to'], $mail['name'])->subject('Application Reminder');
                    }
                });
                if (self::LIVE) {
                    TextService::sendSMS($applicant->mobile, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                } else {
                    TextService::sendSMS(self::TEST_MOBILE, 'Hi - I see that you started applying to us recently. Your form is still saved for you if you’d like to finish it off? Cavalry Healthcare');
                }
            } catch (\Exception $e) {
            }
            $applicant->update(['reminder_count' => 1]);
        }
    }
}
