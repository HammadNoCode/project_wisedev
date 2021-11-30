<?php

namespace App\Http\Controllers\Staff\Recruitment\Interview;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;

class UpdateContactedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id)
    {
        $applicant = Application::where('id', $id)->where('declaration', null)->firstOrFail();
        $applicant->update(['phoned' => 1]);
        return response()->json(['message' => 'Contacted'], 200);
    }
}
