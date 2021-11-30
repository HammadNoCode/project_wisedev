<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\ApplicantCompliance;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Compliance;
use App\Models\Staff\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class PipelineController extends Controller
{

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datatable = Application::where('hired', null)
            ->where('status', 1)
            ->where('test', $this->env())
            ->position($request->position)
            ->branch($request->branch)
            ->driver($request->driver)
            ->score($request->score)
            ->shift($request->shift)
            ->favourite($request->favourite)
            ->sort($request->sort)
            ->hours($request->hours)
            ->search($request->search)
            ->with('interview_notes')
            ->with('dbs_details')
            ->with('total_compliance_items', function ($query) {
                $query->whereHas('compliance', function ($query) {
                    $query->where('type', 1);
                });
            })
            ->withCount(['total_compliance_items' => function (Builder $query) {
                $query->whereHas('compliance', function ($query) {
                    $query->where('type', 1);
                });
            }])
            ->get();

        switch ($request->compliance) {
            case ('most'):
                $sorted = $datatable->sortByDesc('total_compliance_items_count');
                return  response()->json($this->paginateArray($sorted->values()->all(), 15), 200);
            case ('least'):
                $sorted = $datatable->sortBy('total_compliance_items_count');
                return  response()->json($this->paginateArray($sorted->values()->all(), 15), 200);
            case ('all'):
                return  response()->json($this->paginateArray($datatable->values()->all(), 15), 200);
        }
    }

    public function paginateArray(
        array $items,
        int $perPage = 5,
        int $page = null,
        array $options = []
    ): \Illuminate\Pagination\LengthAwarePaginator {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    /**
     * Show stats function function
     *
     * @param Request $request
     * @return void
     */
    public function stats(Request $request)
    {
        $hours_pw = Application::where('hired', null)
            ->where('status', 1)
            ->where('test', $this->env())
            ->position($request->position)
            ->branch($request->branch)
            ->driver($request->driver)
            ->score($request->score)
            ->shift($request->shift)
            ->favourite($request->favourite)
            ->sort($request->sort)
            ->hours($request->hours)
            ->search($request->search)
            ->sum('hours_pw');
        return response()->json($hours_pw);
    }

    /**
     * Convert requested shifts into hours
     * 1 shift = 12 hours
     *
     * @return void
     */
    public function convert_shifts_to_hours_per_week()
    {
        $applicants = Application::where('shifts', '!=', null)->where('hours_pw', 0)->select('id', 'shifts')->get();
        echo count($applicants) . "\n";
        foreach ($applicants as $applicant) {
            Application::whereId($applicant->id)->update([
                'hours_pw' => (int) $applicant->shifts * 12,
            ]);
        }
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
        $application = Application::where('id', $id)->first();
        $application->update([
            'favourite' => $request->favourite,
        ]);
        return response()->json([
            'message' => 'Application updated',
        ], 200);
    }

    /**
     * Get list of missing compliance for each applicant/staff member
     *
     * @param int $id
     * @return void
     */
    public function getMissingCompliance($id)
    {
        $applicant = Application::where('id', $id)->first();

        $completed_compliance = ApplicantCompliance::where('applicant_id', $id)
            ->pluck('document_id');

        $missing_compliance = Compliance::whereNotIn('id', $completed_compliance)
            ->document($applicant->position)
            ->get();

        return response()->json($missing_compliance, 200);
    }
}
