<?php

namespace App\Http\Controllers\GoogleMap;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Coordinates;
use App\Models\Staff\Map\ApplicantMap;
use App\Services\MapService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class MarkerController extends Controller
{
    public function getCarehomeCoordinates()
    {
        $coordinates = Coordinates::select('location_id', 'lat', 'lng')->with('carehome')->get();
        return response()->json($coordinates, 200);
    }

    public function getApplicantCoordinates(Request $request)
    {
        $cacheLabel = "-markers-$request->filter-$request->filterBy";
        $cacheExpiration = Carbon::now()->diffInSeconds(Carbon::now()->endOfDay());
        $coordinates = Cache::remember($cacheLabel, $cacheExpiration,  function () use ($request) {
            return MapService::build($request->filter, $request->filterBy);
        });
        return response()->json($coordinates, 200);
    }
}
