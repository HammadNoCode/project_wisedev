<?php

namespace App\Http\Controllers\Staff\Vaccination;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Clinical\ClinicalStaff;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    const LIVE = true; // change to TRUE before commit
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function portal_invite()
    {
        $portal_ids = ClinicalStaff::where('vaccination_invite', 0)->where('staff_id', 3911)->get('staff_id'); // remove where ID = ? before commit
        echo count($portal_ids) . "\n";
        foreach ($portal_ids as $staff) {
            $application = Application::where('id', $staff->staff_id)->first();
            $mail = [
                'name' => $application->first_name,
                'to' => $application->email,
                'last_name' => $application->last_name,
                'pin_number' => $staff->staff_id,
            ];
            Mail::send('mail.staff.vaccination.invite', $mail, function ($message) use ($mail) {
                $message->from('admin@cavalrycare.co.uk');
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Vaccination alert');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Vaccination alert');
                }
            });
            ClinicalStaff::where('staff_id', $staff->staff_id)->update(['vaccination_invite' => 1]);
        }
    }

    public function pulse_invite()
    {
        $pulse_ids = Staff::where('vaccination_invite', 0)->where('unique_id', 11111)->get('unique_id'); // remove where ID = ? before commit
        echo count($pulse_ids) . "\n";
        foreach ($pulse_ids as $staff) {
            $record = Staff::where('unique_id', $staff->unique_id)->first();
            $mail = [
                'name' => $record->name,
                'to' => $record->email,
                'last_name' => $record->last_name,
                'pin_number' => $record->unique_id,
            ];
            Mail::send('mail.staff.vaccination.invite', $mail, function ($message) use ($mail) {
                $message->from('admin@cavalrycare.co.uk');
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Vaccination alert');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Vaccination alert');
                }
            });
            Staff::where('unique_id', $staff->unique_id)->update(['vaccination_invite' => 1]);
        }
    }
}
