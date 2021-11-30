<?php

namespace App\Http\Controllers\Covid\Vaccination\Records;

use App\Http\Controllers\Controller;
use App\Models\Pulse\Staff;
use Illuminate\Http\Request;

class PulseController extends Controller
{
    public function show(Request $request)
    {
        $records = Staff::select('*')
            ->whereHas('latest_vaccination')
            ->with('latest_vaccination')
            ->withCount('latest_vaccination')
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
}
