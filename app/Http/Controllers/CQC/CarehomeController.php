<?php

namespace App\Http\Controllers\CQC;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome;
use App\Models\Staff\Recruitment\Postcodes;
use Illuminate\Http\Request;

class CarehomeController extends Controller
{
    /**
     * Show all carehomes
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = Carehome::search($request->search)
            ->filter($request->filter)
            ->range($request->range)
            ->branch($request->branch)
            ->favourited($request->favourited)
            ->select('*')
            ->paginate(15);
        return response()->json($data, 200);
    }

    /**
     * Show carehome
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $data = Carehome::where('location_id', $id)
            ->with('specialisms')
            ->with('service_types')
            ->first();
        return response()->json($data, 200);
    }

    /**
     * Update carehome agency
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $carehome = Carehome::where('id', $id)->firstOrFail();
        $carehome->update([
            'favourited' => $request->favourited['favourited'],
            'agency_status' => $request->agency_status,
            'status' => $request->carehome_status
        ]);
        return response()->json([
            'message' => 'Agency Status Updated'
        ], 200);
    }

    /**
     * Assign carehomes to a branch
     *
     * @return void
     */
    public function assign_branch()
    {
        $data = Carehome::whereNull('branch_id')->whereNotNull('postal_code')->select('id', 'postal_code')->get();
        echo count($data) . "\n";
        foreach ($data as $carehome) {
            $postcodeArray = str_split($carehome->postal_code);
            if (is_int($postcodeArray[1])) {
                $postcode = $postcodeArray[0];
            } else {
                $postcode = $postcodeArray[0] . $postcodeArray[1];
            }
            $branchId = Postcodes::wherePostcodePrefix($postcode)->value('branch_id');
            if (!$branchId) {
                $branchId = 2;
            }
            Carehome::where('id', $carehome->id)->update(['branch_id' => $branchId]);
        }
    }
}
