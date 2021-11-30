<?php

namespace App\Http\Controllers\Staff\Recruitment\Compliance;

use Illuminate\Http\Request;
use App\Models\Staff\Recruitment\{ApplicantCompliance, Application, Compliance as Documents, Compliance, DocumentDetails, Reference};
use App\Http\Requests\Compliance\{StoreRequest};
use App\Http\Controllers\Controller;
use App\Models\Staff\Events\Attendee;
use Illuminate\Database\Eloquent\Builder;

class DetailsController extends Controller
{
    /**
     * List of required compliance items for each role
     *
     * @param int $id
     * @return void
     */
    public function getDocuments($id)
    {
        $application = Application::where('id', $id)->value('position');

        if ($application === 'Healthcare Assistant' || $application === 'Senior Healthcare Assistant' || $application === 'Support Worker') {
            $documents = Documents::select('*')->where('type', 1)->where('name', '!=', 'Nurse Pin Number')->where('deleted', 0)->get();
        } else {
            $documents = Documents::select('*')->where('type', 1)->where('deleted', 0)->get();
        }
        return response()->json($documents, 200);
    }

    /**
     * Show applications references function
     *
     * @param int $id
     * @return void
     */
    public function getReferees($id)
    {
        return Reference::whereApplicantId($id)->get();
    }

    /**
     * Show induction attendance function
     *
     * @param int $id
     * @return void
     */
    public function induction_attendance($id)
    {
        $attendance = Attendee::where('attendee_id', $id)->whereHas('event', function (Builder $query) {
            $query->where('type', 1);
        })->with('application')->with('event')->get();
        return response()->json($attendance, 200);
    }

    /**
     * Show training attendance function
     *
     * @param int $id
     * @return void
     */
    public function training_attendance($id)
    {
        $attendance = Attendee::where('attendee_id', $id)->whereHas('event', function (Builder $query) {
            $query->where('type', 2);
        })->with('application')->with('event')->get();
        return response()->json($attendance, 200);
    }

    /**
     * Store completed compliance
     *
     * @param int $applicant_id
     * @param int $id
     * @param StoreRequest $request
     * @return void
     */
    public function store($applicant_id, $id, StoreRequest $request)
    {
        $applicant = Application::where('id', $applicant_id)->first();
        $document = Documents::where('id', $id)->firstOrFail();
        $check = DocumentDetails::whereDocumentId($id)->whereApplicantId($applicant_id)->exists();

        if ($check) {
            DocumentDetails::whereDocumentId($id)->whereApplicantId($applicant_id)->update([
                'dbs_number' => $request->dbs_number,
                'issue_date' => $request->issue_date,
                'date_checked' => $request->date_checked,
                'online' => $request->online,
                'passport_number' => $request->passport_number,
                'passport_expiry' => $request->passport_expiry,
                'visa_number' => $request->visa_number,
                'visa_type' => $request->visa_type,
                'hours' => $request->hours,
                'visa_expiry' => $request->visa_expiry,
            ]);
        } else {
            (new DocumentDetails())->createDetails($applicant, $id, $request);
        }
        return response()->json([
            'message' => 'Document details stored'
        ], 201);
    }

    /**
     * Show completed compliance details function
     *
     * @param int $applicant_id
     * @param int $id
     * @return void
     */
    public function show($applicant_id, $id)
    {
        return response()->json(DocumentDetails::where('document_id', $id)->where('applicant_id', $applicant_id)->get(), 200);
    }

    /**
     * Update existing completed compliance details function
     *
     * @param int $id
     * @param int $applicant_id
     * @param Request $request
     * @return void
     */
    public function update($id, $applicant_id, Request $request)
    {
        $details = DocumentDetails::where('document_id', $id)->where('applicant_id', $applicant_id)->firstOrFail();
        $details->update([
            'dbs_number' => $request->dbs_number,
            'issue_date' => $request->issue_date,
            'date_checked' => $request->date_checked,
            'online' => $request->online,
            'passport_number' => $request->passport_number,
            'passport_expiry' => $request->passport_expiry,
            'visa_number' => $request->visa_number,
            'visa_type' => $request->visa_type,
            'hours' => $request->hours,
            'visa_expiry' => $request->visa_expiry,
        ]);
        return response()->json([
            'message' => 'Compliance details updated'
        ], 200);
    }
}
