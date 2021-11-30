<?php

namespace App\Http\Controllers\Covid\Results;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Covid\Results;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ResultsController extends Controller
{

    /**
     * Get portal staff who have uploaded a covid-19 test
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $datatable = Results::where('staff_id', '!=', null)
            ->orderBy('created_at', 'desc')
            ->archived($request->archived)
            ->resultFilter($request->filter)
            ->search($request->search)
            ->get()
            ->unique('staff_id');

        return response()->json($this->paginateArray($datatable->values()->all(), 20), 200);
    }

    public function paginateArray(
        array $items,
        int $perPage = 20,
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

    public function get_image($id, $filename)
    {
        return Storage::disk('s3CovidTests')->response('covid-tests/results/' . $id  . '/' . $filename);
    }

    public function show(Request $request)
    {

        $datatable = Results::where('staff_id', $request->staff_id)
            ->archived($request->archived)
            ->select('*')
            ->orderBy('test_date', 'desc')
            ->paginate(15);
        return response()->json($datatable, 200);
    }
}
