<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome;
use App\Models\CQC\Carehome\Agency;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    /**
     * Show agencies
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $data = Agency::where('location_id', $id)->get();
        return response()->json($data, 200);
    }

    /**
     * store new agency
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request)
    {
        (new Agency())->createAgency($request);
        return response()->json([
            'message' => 'Agency Added'
        ], 201);
    }

    /**
     * Update carehome agency
     *
     * @return void
     */
    public function update()
    {
    }

    /**
     * Destroy carehome agency
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        Agency::where('id', $id)->delete();
        return response()->json([
            'message' => 'Agency Removed'
        ], 200);
    }
}
