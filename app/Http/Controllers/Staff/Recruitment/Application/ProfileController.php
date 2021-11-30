<?php

namespace App\Http\Controllers\Staff\Recruitment\Application;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application\Profile;

class ProfileController extends Controller
{
    /**
     * Store function
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        $profile = (new Profile())->createProfile($id, $request);
        return response()->json(['message' => 'Profile details updated'], 201);
    }

    /**
     * Show function
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $response = Profile::where('applicant_id', $id)->first();
        return response()->json($response, 200);
    }

    /**
     * Update function
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::where('applicant_id', $id)->firstOrFail();
        $profile->update($request->all());
        return response()->json(['message' => 'Profile details updated'], 200);
    }
}
