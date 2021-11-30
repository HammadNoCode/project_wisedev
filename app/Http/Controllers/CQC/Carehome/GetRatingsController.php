<?php

namespace App\Http\Controllers\CQC\Carehome;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome;
use Illuminate\Http\Request;

class GetRatingsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $ratings = Carehome::where('rating', '!=', '')->select('rating')->groupBy('rating')->get();
        return response()->json($ratings);
    }
}
