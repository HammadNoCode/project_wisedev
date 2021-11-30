<?php

namespace App\Http\Controllers\Staff\Recruitment\Reference\Email;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReminderController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function automated_reminder()
    {
        $applicants = Application::where('status', 1)
            ->where('hired', null)
            ->where('test', 0)
            ->pluck('id');

        $contactable = Reference::where('status', 1)
            ->where('reminder_count', '<', 5)
            ->whereIn('applicant_id', $applicants)
            ->get();

        foreach ($contactable as $reference) {

            $applicant = Application::where('id', $reference->applicant_id)
                ->select('first_name', 'last_name', 'position')
                ->first();

            $mail = [
                'token' => $reference->token,
                'applicant_id' => $reference->applicant_id,
                'name' => $reference->name,
                'to' => $reference->email,
                'applicant' => $applicant->first_name . ' ' . $applicant->last_name,
                'position' => $applicant->position
            ];

            try {
                if ((int) $reference->type ==  1) {

                    Mail::send('mail.staff.reference.professional.reminder', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Professional Reference Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Professional Reference Reminder');
                        }
                    });
                } else {

                    Mail::send('mail.staff.reference.personal.reminder', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Personal Reference Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Personal Reference Reminder');
                        }
                    });
                }
                $reference->increment('reminder_count');
                $reference->save();
            } catch (\Exception $e) {

                echo 'exception caught ', $e->getMessage(), '\n';
            }
        }
    }
}
