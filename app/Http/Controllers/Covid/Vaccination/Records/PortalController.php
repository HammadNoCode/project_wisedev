<?php

namespace App\Http\Controllers\Covid\Vaccination\Records;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Vaccination\Proof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function show(Request $request)
    {
        $records = Application::select('id', 'first_name', 'last_name', 'mobile', 'email')
            ->whereHas('latest_vaccination')
            ->with('latest_vaccination')
            ->withCount('latest_vaccination')
            ->where('hired', 1)
            ->paginate(15);

        if ($request->has('search') && $request->search != '') {
            $items = $records->getCollection()->filter(function ($item, $key) use ($request) {
                $name = strtoupper($item->first_name . ' ' . $item->last_name);
                return str_contains($name, strtoupper($request->search));
            });

            $records->setCollection($items);
            return response()->json($records, 200);
        }

        return response()->json($records, 200);
    }

    public function get_image($id, $filename)
    {
        return Storage::disk('s3Vaccinations')->response('vaccinations/' . $id  . '/' . $filename);
    }

    public function get_all_results($id)
    {
        $app_last_name = Application::where('id', $id)->value('last_name');
        $stf_last_name = Staff::where('unique_id', $id)->value('last_name');

        if (Proof::where('staff_id', $id)->where('last_name', $app_last_name)->exists()) {
            $results = Proof::where('staff_id', $id)
                ->where('last_name', $app_last_name)
                ->select('*', 'staff_id as first_name', 'last_name')
                ->orderBy('vaccination_date', 'desc')
                ->paginate(15);
        } else {
            $results = Proof::where('staff_id', $id)
                ->where('last_name', $stf_last_name)
                ->select('*', 'staff_id as first_name', 'last_name')
                ->orderBy('vaccination_date', 'desc')
                ->paginate(15);
        }
        return response()->json($results, 200);
    }
}
