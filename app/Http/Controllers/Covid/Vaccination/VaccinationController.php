<?php

namespace App\Http\Controllers\Covid\Vaccination;

use App\Http\Controllers\Controller;
use App\Models\Covid\Vaccination;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class VaccinationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datatable = Vaccination::whereHas('application')
            ->where('staff_id', '!=', null)
            ->orderBy('created_at', 'desc')
            ->archived($request->archived)
            ->search($request->search)
            ->with('application')
            ->withCount('vaccination')
            ->get()
            ->unique('staff_id');

        return response()->json($this->paginateArray($datatable->values()->all(), 20), 200);
    }

    /**
     * Paginate array
     *
     * @param array $items
     * @param integer $perPage
     * @param integer $page
     * @param array $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vaccination = Vaccination::where('staff_id', $id)->get();
        return response()->json($vaccination, 200);
    }

    /**
     * get vaccination evidence
     *
     * @param int $staff_id
     * @param string $filename
     * @return void
     */
    public function vaccinationEvidence($staff_id, $filename)
    {
        return Storage::disk('s3Vaccinations')->response('vaccinations/' . $staff_id . '/' . $filename);
    }
}
