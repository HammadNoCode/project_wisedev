<?php

namespace App\Http\Controllers\Staff\Recruitment\Compliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Models\Staff\Recruitment\{Application, Log, ApplicantCompliance as AppDocuments, Compliance as Documents, Interview};
use App\Models\Staff\User\{Branches, User};
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AppComplianceController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param int $applicant_id
     * @param int $id
     * @return void
     */
    public function store(Request $request, $applicant_id, $id)
    {
        $applicant = Application::where('id', $applicant_id)->first();
        $document = Documents::where('id', $id)->firstOrFail();
        $appDocument = (new AppDocuments())->createDocument($applicant, $id);
        return response()->json([
            'message' => 'Compliance item checked'
        ], 201);
    }

    /**
     * Update function
     *
     * @param Request $request
     * @param int $applicant_id
     * @param int $id
     * @return void
     */
    public function update(Request $request, $applicant_id, $id)
    {
        AppDocuments::where('applicant_id', $applicant_id)->where('document_id', $id)->firstOrFail()
            ->update([
                'issue_date' => $request->issue_date,
                'renewal_date' => $request->renewal_date,
            ]);
        return response()->json([
            'message' => 'Document dates updated'
        ], 200);
    }

    /**
     * Destroy function
     *
     * @param int $applicant_id
     * @param int $id
     * @return void
     */
    public function destroy($applicant_id, $id)
    {
        AppDocuments::where('applicant_id', $applicant_id)->where('document_id', $id)->firstOrFail()->delete();
        return response()->json([
            'message' => 'Document record deleted'
        ], 200);
    }

    /**
     * Show documentation compliance function
     *
     * @param int $applicant_id
     * @return void
     */
    public function get_compliance_documents($applicant_id)
    {

        $app_position = Application::where('id', $applicant_id)->value('position');
        $documents = Documents::document($app_position)->get();
        foreach ($documents as $document) {
            if ($appDocument = AppDocuments::where('applicant_id', $applicant_id)->where('document_id', $document->id)->first()) {
                $document->type = 1;
                $document->checked = true;
                $document->issue_date = $appDocument->issue_date;
                $document->renewal_date = $appDocument->renewal_date;
            } else {
                $document->checked = false;
            }
        }
        return response()->json($documents, 200);
    }

    /**
     * Show training compliance requirements function
     *
     * @param [type] $applicant_id
     * @return void
     */
    public function get_compliance_training($applicant_id)
    {
        $documents = Documents::select('*')->whereType(2)->where('deleted', 0)->get();
        foreach ($documents as $document) {
            if ($appDocument = AppDocuments::where('applicant_id', $applicant_id)->where('document_id', $document->id)->first()) {
                $document->type = $document->type;
                $document->checked = true;
                $document->issue_date = $appDocument->issue_date;
                $document->renewal_date = $appDocument->renewal_date;
            } else {
                $document->checked = false;
            }
        }
        return response()->json($documents, 200);
    }

    /**
     * Update confirmed compliance expiry dates
     *
     * @return void
     */
    public function update_expired()
    {
        $expired = AppDocuments::whereExpired(null)->where('renewal_date', '<', Carbon::now())->get();
        echo count($expired) . "\n";
        foreach ($expired as $document) {
            $document->update([
                'expired' => 1
            ]);
        }
    }

    /**
     * Compliance documentaion proof upload
     *
     * @param Request $request
     * @return void
     */
    public function document_upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);
        return response()->json(['success' => 'You have successfully upload file.']);
    }

    /**
     * Auto fill training qualifications expiry date to expire 1 year after completion
     *
     * @param int $id
     * @return void
     */
    public function auto_fill_renewal($id)
    {
        $documents = AppDocuments::where('applicant_id', $id)->get();
        foreach ($documents as $document) {
            $date = Carbon::parse($document->issue_date);
            $year = $date->addYear();
            $document->update([
                'renewal_date' => $year,
            ]);
        }
        return response()->json([
            'message' => 'Renewal dates filled'
        ], 200);
    }
}
