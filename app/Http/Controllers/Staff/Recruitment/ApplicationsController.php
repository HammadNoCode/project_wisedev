<?php

namespace App\Http\Controllers\Staff\Recruitment;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Models\Staff\Recruitment\{ApplicantCompliance,
    Compliance as Document,
    Application,
    Reference,
    Log,
    Interview,
    Postcodes,
    EmploymentHistory as Employment,
    };
use App\Models\Staff\User\{Branches, User};
use App\Models\Staff\Map\{ApplicantMap as Map};
use App\Models\Staff\Clinical\ClinicalStaff;
use App\Http\Requests\Applicant\{UpdateRequest};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApplicationsController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    /**
     * Index function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {

        $data = Application::where('test', $this->env())
            ->where('pulse', 0)
            ->orWhere('pulse', null)
            ->status($request->filter)
            ->statusSub($request->statusSub)
            ->branch($request->filterBranch)
            ->position($request->position)
            ->sort($request->sort)
            ->source($request->source)
            ->search($request->search)
            ->select('*', 'status', 'branch_id', 'id as interview_id', 'id as references', 'created_at as completed_at')
            ->withCount('completed_document_compliance')
            ->paginate(10);
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $application = Application::where('id', $id)
            ->whereTest($this->env())
            ->with('latest_test')
            ->with('about_me')
            ->first();
        return response()->json($application, 200);
    }

    /**
     * Update function
     *
     * @param int $id
     * @param UpdateRequest $request
     * @return void
     */
    public function update($id, UpdateRequest $request)
    {
        $v = Validator::make($request->all(), [
            'file' => 'sometimes|required|mimes:pdf,docx,doc',
        ]);
        if($v->fails()){

            return response()->json(['message' => 'The please upload pdf or docx file'], 401);
        }

        ini_set('memory_limit', '-1');
        $files = $request->file('file');
        if(!empty($files)) {
            $filename = 'resume'. $id . '.' . $files->getClientOriginalExtension();
            $image_full_name = $filename;
            $upload_path = 'public/attachment/app_resume/';
            $image_url = $upload_path . $image_full_name;
            $files->move($upload_path, $image_full_name);
            Application::where('id',$id)->first()->update([
                'resume_url' => $image_url,
            ]);
        }
        $applicant = Application::where('id', $id)->firstOrFail();
        $applicant->update($request->all());
        (new Log())->createLog(
            $applicant->id,
            session('staff_id'),
            'Applicant details updated'
        );
        if ((int) $applicant->status ==  2) {
            $mail = [
                'name' => $applicant->first_name,
                'to' => $applicant->email,
            ];
            Mail::send('mail.staff.application.reject', $mail, function ($message) use ($mail) {
                $message->from('join@cavalrycare.co.uk');
                if (self::LIVE) {
                    $message->to($mail['to'], $mail['name'])->subject('Application Update');
                } else {
                    $message->to(self::TEST_EMAIL, $mail['name'])->subject('Application Update');
                }
            });
        } else {
            return response()->json([
                'message' => 'The application has been updated'
            ], 200);
        }
    }

    /**
     * Update application status
     * If hired update hired and create a clinical staff record
     * Record update to logs
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update_status(Request $request, $id)
    {
       // dd($request->all());
        $applicant = Application::where('id', $id)->firstOrFail();
        if ($request->hire) {
            $applicant->update([
                'hired' => $request->hire,
                'hire_date' => Carbon::now(),
            ]);
            ClinicalStaff::updateOrInsert([
                'staff_id' => $applicant->id,
                'hired_by' => session('staff_id'),
                'test' => $this->env(),
            ]);
        } else {
            if ($request->status == 3) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                    'accept_date' => Carbon::now(),
                ]);
            } elseif($request->status == 0) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }elseif($request->status == 1) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }
            elseif($request->status == 2) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }
            elseif($request->status == 4) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }
            elseif($request->status == 5) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }
            elseif($request->status == 6) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }
            elseif($request->status == 7) {
                $applicant->update([
                    'status' => $request->status,
                    'sub_status' => $request->sub_status,
                ]);
            }

        }

        (new Log())->createLog(
            $applicant->id,
            session('staff_id'),
            'Application status updated'
        );

        return response()->json([
            'message' => 'Status updated'
        ], 200);
    }

    /**
     * Destroy function
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        Map::where('applicant_id', $id)->delete();
        Interview::where('applicant_id', $id)->delete();
        Reference::where('applicant_id', $id)->delete();
        Employment::where('applicant_id', $id)->delete();
        Log::where('applicant_id', $id)->delete();
        ClinicalStaff::where('staff_id', $id)->delete();
        Application::where('id', $id)->delete();
        return response()->json([
            'message' => 'The application has been deleted'
        ], 200);
    }

    /**
     * Create blank application function
     *
     * @return void
     */
    public function create()
    {
        return response()->json(['id' => Application::insertGetId(['test' => $this->env()])], 200);
    }


    public function get_branches()
    {
        $branches = Branches::select('id', 'name')->get();
        return response()->json($branches, 200);
    }

    public function sub_status(Request $request, $id)
    {
        $sub_s = DB::table('sub_status')->where('status_id', $id)->get();
        return response()->json($sub_s, 200);
    }

    public function sub_status_alph($data)
    {

        if($data === 'Application'){
           $sec = '0';
        }elseif($data === 'Screening'){
            $sec = '1';
        }elseif($data === 'Interview'){
            $sec = '2';
        }elseif($data === 'Offered'){
            $sec = '3';
        }elseif($data === 'Onboarding'){
            $sec = '4';
        }elseif($data === 'Active'){
            $sec = '5';
        }elseif($data === 'Leaver'){
            $sec = '6';
        }elseif($data === 'Pipeline'){
            $sec = '7';
        }elseif($data === 'all'){
            $sec = '100';
        }
        $sub_t = DB::table('sub_status')->where('status_id', $sec)->get();
        return response()->json($sub_t, 200);
    }




}
