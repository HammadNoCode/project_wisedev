<?php

namespace App\Http\Controllers\Staff\Events\Induction;

use App\Models\Staff\Events\Event;
use App\Models\Staff\Events\Attendee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Mail, Validator};
use App\Services\TextService;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class ReminderController extends Controller
{
    const LIVE = false; // change to TRUE before committing
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function event_blackburn_branch_reminder()
    {
        $blackburn = Event::where('type', '1')
            ->where('branch_id', 1)
            ->where('expired', null)
            ->where('date', '=', Carbon::tomorrow())
            ->with('attendees.application')
            ->with('attendees.staff')
            ->get();
        echo count($blackburn) . "\n";
        foreach ($blackburn as $event) {
            foreach ($event->attendees as $attendee) {
                if ($attendee->attendee_type === "Staff") {
                    $mail = [
                        'to' => $attendee->staff->email,
                        'name' => $attendee->staff->name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.blackburn', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                } else {
                    $mail = [
                        'to' => $attendee->application->email,
                        'name' => $attendee->application->first_name . ' ' . $attendee->application->last_name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.blackburn', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                }
            }
        }
    }

    public function event_liverpool_branch_reminder()
    {
        $liverpool = Event::where('type', '1')
            ->where('branch_id', 2)
            ->where('expired', null)
            ->where('date', '=', Carbon::tomorrow())
            ->with('attendees.application')
            ->with('attendees.staff')
            ->get();
        echo count($liverpool) . "\n";
        foreach ($liverpool as $event) {
            foreach ($event->attendees as $attendee) {
                if ($attendee->attendee_type === "Staff") {
                    $mail = [
                        'to' => $attendee->staff->email,
                        'name' => $attendee->staff->name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.liverpool', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                } else {
                    $mail = [
                        'to' => $attendee->application->email,
                        'name' => $attendee->application->first_name . ' ' . $attendee->application->last_name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.liverpool', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                }
            }
        }
    }

    public function event_warrington_branch_reminder()
    {
        $warrington = Event::where('type', '1')
            ->where('branch_id', 3)
            ->where('expired', null)
            ->where('date', '=', Carbon::tomorrow())
            ->with('attendees.application')
            ->with('attendees.staff')
            ->get();
        echo count($warrington) . "\n";
        foreach ($warrington as $event) {
            foreach ($event->attendees as $attendee) {
                if ($attendee->attendee_type === "Staff") {
                    $mail = [
                        'to' => $attendee->staff->email,
                        'name' => $attendee->staff->name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.warrington', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                } else {
                    $mail = [
                        'to' => $attendee->application->email,
                        'name' => $attendee->application->first_name . ' ' . $attendee->application->last_name,
                        'event_type' => $event->type,
                        'location' => ucwords($event->location),
                        'date' => $event->date,
                        'time' => $event->time,
                    ];
                    Mail::send('mail.staff.events.induction.reminder.warrington', $mail, function ($message) use ($mail) {
                        $message->from('join@cavalrycare.co.uk');
                        if (self::LIVE) {
                            $message->to($mail['to'], $mail['name'])->subject('Event Reminder');
                        } else {
                            $message->to(self::TEST_EMAIL, $mail['name'])->subject('Event Reminder');
                        }
                    });
                }
            }
        }
    }
}
