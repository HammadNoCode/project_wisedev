<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReferenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datatable = Reference::status($request->filter)
            ->sort($request->sort)
            ->search($request->search)
            ->select(
                '*',
                'applicant_id as position',
                'applicant_id as first_name',
                'applicant_id as last_name',
                'applicant_id as application_status',
                'name as name',
                'status as responded',
                'reminder_count',
                'updated_at as completed_at',
            )
            ->paginate(25);
        return response()->json($datatable, 200);
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $invites = Reference::where('applicant_id', $id)
            ->select('*', 'status as responded', 'updated_at as completed_at')
            ->get();
        return response()->json($invites, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invite = (new Reference())->createInvite($request);
        if ($request->type == 1) {
            $type = 'Professional request';
        } else {
            $type = 'Personal request';
        }
        $this->mailTemplate($type, $invite);
        return response()->json(
            [
                'message' => 'Reference stored'
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reference = Reference::where('id', $id)->firstOrFail();
        $reference->update([
            'email' => $request->data['email'],
            'mobile' => $request->data['mobile'],
            'occupation' => $request->data['occupation'],
            'safeguard_check' => $request->data['safeguard_check'],
            'employed_to' => $request->data['employed_to'],
            'employed_from' => $request->data['employed_from'],
            'known_since' => $request->data['known_since'],
            'related' => $request->data['related'],
            'capacity' => $request->data['capacity'],
            'note' => $request->data['note'],
            'status' => 2,
            'manually' => $request->data['manually'],
            'staff_note' => $request->data['staff_note'],
        ]);
        return response()->json(
            [
                'message' => 'Reference updated'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invite = Reference::where('id', $id)->delete();
        return response()->json(
            [
                'message' => 'Reference deleted'
            ],
            200
        );
    }

    public function reminder(Request $request)
    {
        $invite = Reference::where('id', $request->id)->firstOrFail();
        $invite->update([
            'reminder_count' => $invite->reminder_count + 1,
        ]);
        if ($request->type == 1) {
            $type = 'Professional reminder';
        } else {
            $type = 'Personal reminder';
        }
        $this->mailTemplate($type, $invite);
        return response()->json(
            [
                'message' => 'Reminder sent'
            ],
            200
        );
    }

    public function request(Request $request)
    {
        $invite = Reference::where('id', $request->id)->firstOrFail();
        $invite->update([
            'status' => 1,
        ]);
        if ($request->type == 1) {
            $type = 'Professional request';
        } else {
            $type = 'Personal request';
        }
        $this->mailTemplate($type, $invite);
        return response()->json(
            [
                'message' => 'Request sent'
            ],
            200
        );
    }

    /**
     * Email template funtion
     *
     * @param string $type
     * @param object $invite
     * @return void
     */
    public function mailTemplate($type, $invite)
    {
        $applicant = Application::where('id', $invite->applicant_id)->firstOrFail();
        switch ($type) {
            case ('Professional request'):
                $template = 'mail.staff.reference.professional.request';
                break;
            case ('Personal request'):
                $template = 'mail.staff.reference.personal.request';
                break;
            case ('Professional reminder'):
                $template = 'mail.staff.reference.professional.reminder';
                break;
            case ('Personal reminder'):
                $template = 'mail.staff.reference.personal.reminder';
                break;
        }
        $mail = [
            'token' => $invite->token,
            'applicant_id' => $invite->applicant_id,
            'name' => $invite->name,
            'to' => $invite->email,
            'applicant' => $applicant->first_name . ' ' . $applicant->last_name,
            'position' => $applicant->position
        ];
        Mail::send($template, $mail, function ($message) use ($mail, $type) {
            $message->from('join@cavalrycare.co.uk');
            $message->to($mail['to'], $mail['name'])->subject($type);
        });
    }
}
