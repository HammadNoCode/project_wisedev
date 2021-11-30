<?php

namespace App\Http\Controllers\Staff\Events\Induction;

use App\Models\Staff\User\User as Staff;
use App\Models\Staff\Clinical\ClinicalStaff;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Events\Event;
use App\Models\Staff\Events\Attendee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Validator};
use App\Services\TextService;
use App\Http\Controllers\Controller;

class AttendeeController extends Controller
{
    const LIVE = true; // change to TRUE before committing
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function index()
    {
        $attendee = Attendee::select(
            '*',
            'attendee_id as first_name',
            'attendee_id as last_name',
            'attendee_id as email',
            'attendee_type'
        )->paginate(15);
        return response()->json($attendee, 200);
    }

    public function store(Request $request, $id)
    {
        $attendee = (new Attendee())->createBookingRequest($request, $id);
        if ($attendee->attendee_type == 'Applicant') {
            $applicant = Application::where('id', $attendee->attendee_id)->firstOrFail();
            $mail = [
                'token' => $attendee->token,
                'to' => $applicant->email,
                'name' => $applicant->first_name,
            ];
            Mail::send('mail.staff.events.induction.invite', $mail, function ($message) use ($mail) {
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Event Invite');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Invite');
                }
            });
        } else {
            $staff = Staff::where('id', $attendee->attendee_id)->firstOrFail();
            $mail = [
                'token' => $attendee->token,
                'to' => $staff->email,
                'name' => $staff->name,
            ];
            Mail::send('mail.staff.events.induction.invite', $mail, function ($message) use ($mail) {
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Event Invite');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Invite');
                }
            });
        }
        return response()->json([
            'message' => 'Booking successful'
        ], 201);
    }

    public function show($id)
    {
        $attendee = Attendee::where('event_id', $id)->with('application')->with('staff')->paginate(10);
        return response()->json($attendee, 200);
    }

    public function destroy($id)
    {
        $attendee = Attendee::where('id', $id)
            ->firstOrFail();
        $event = Attendee::where('id', $attendee->id)
            ->firstOrFail();
        Attendee::where('id', $id)->delete();
        return response()->json([
            'message' => 'Attendee removed from event'
        ], 200);
    }

    public function update($id)
    {
        $attendee = Attendee::where('id', $id)->firstOrFail();
        $attendee->update([
            'status' => 1,
        ]);
        if ($attendee->attendee_type == 'Applicant') {
            $applicant = Application::where('id', $attendee->attendee_id)->firstOrFail();
            $mail = [
                'to' => $applicant->email,
                'name' => $applicant->first_name,
            ];
            Mail::send('mail.staff.events.induction.cancellation', $mail, function ($message) use ($mail) {
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Event Confirmation');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Confirmation');
                }
            });
        } else {
            $staff = Staff::where('id', $attendee->attendee_id)->firstOrFail();
            $mail = [
                'to' => $staff->email,
                'name' => $staff->name,
            ];
            Mail::send('mail.staff.events.induction.cancellation', $mail, function ($message) use ($mail) {
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Event Confirmation');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Confirmation');
                }
            });
        }
        return response()->json([
            'message' => 'Attendee Updated'
        ], 200);
    }

    public function confirmation(Request $request, $id)
    {
        $attendee = Attendee::where('id', $id)->firstOrFail();
        $attendee->update([
            'attendance' => $request->attendance,
        ]);
        return response()->json([
            'message' => 'Attendance status updated'
        ], 200);
    }

    public function get_applicant()
    {
        return response()->json(Application::where('status', '=', '1')->orderBy('first_name', 'asc')->get(), 200);
    }

    public function get_staff()
    {
        return response()->json(Staff::select('*')->get(), 200);
    }
}
