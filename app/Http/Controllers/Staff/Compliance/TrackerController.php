<?php

namespace App\Http\Controllers\Staff\Compliance;

use Illuminate\Http\Request;
use App\Models\Staff\Recruitment\{Compliance};
use App\Models\Staff\Compliance\Tracker;
use App\Models\Staff\User\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TrackerController extends Controller
{
    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    /**
     * Show soon to expire compliance documents
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $filteredDocument = $this->filter_document((clone $filtered), $request->filterDocument);
        $sorted = $this->sort((clone $filteredDocument), $request->sort);
        $selected = $sorted
            ->select(
                '*',
                'applicant_id',
                'applicant_id as first_name',
                'applicant_id as last_name',
                'document_id',
                'document_id as document_name',
                'expired'
            )
            ->orderBy('expiry_date', 'asc')
            ->whereTest($this->env())
            ->paginate(15);
        return response()->json($selected, 200);
    }

    /**
     * Index epiry date filter
     *
     * @param date $filter
     * @return void
     */
    public function filter($filter)
    {
        $date1 = Carbon::now();
        $date2 = Carbon::now()->addDays(21);

        if ($filter == 0) {
            return Tracker::whereRaw('renewal_date BETWEEN ? AND ?', [$date1, $date2]);
        }
        if ($filter == 1) {
            return Tracker::where('expired', 0)->whereBetween('renewal_date', [$date1, $date2]);
        }
        if ($filter == 2) {
            return Tracker::where('expired', 1);
        }
    }

    /**
     * Index document_id filter
     *
     * @param [type] $tracker
     * @param [type] $filterDocument
     * @return void
     */
    public function filter_document($tracker, $filterDocument)
    {
        if ($filterDocument == 0) {
            return $tracker;
        }
        return $tracker->where('document_id', $filterDocument);
    }

    /**
     * Sort index
     *
     * @param [type] $tracker
     * @param [type] $sort
     * @return void
     */
    public function sort($tracker, $sort)
    {
        if ($sort == 0) {
            return $tracker;
        }
        if ($sort == 1) {
            return $tracker->whereHas('document', function ($query) {
                return $query->where('type', 1);
            });
        }
        if ($sort == 2) {
            return $tracker->whereHas('document', function ($query) {
                return $query->where('type', 2);
            });
        }
    }

    /**
     * Compliance document names
     *
     * @return void
     */
    public function get_compliance_names()
    {
        $compliance = Compliance::all()->unique('name');
        return response()->json($compliance, 200);
    }
}
