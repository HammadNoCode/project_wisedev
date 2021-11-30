<?php

namespace App\Http\Controllers\Staff\Recruitment\Application;

use App\Models\Staff\Recruitment\{EmploymentHistory as Employment};
use Illuminate\Http\Request;
use App\Services\TextService;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Http\Controllers\Controller;

class EmploymentController extends Controller
{
    /**
     * Show function
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        return response()->json(
            Employment::where('applicant_id', $id)
                ->select('*')
                ->get(),
            200
        );
    }

    /**
     * Store function
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        (new Employment())->insert([
            'applicant_id' => $id,
            'name' => $request->name,
            'role' => $request->role,
            'employed_from' => $request->employed_from,
            'employed_to' => $request->employed_to,
        ]);
        return response()->json([
            'message' => 'Employment record saved'
        ], 200);
    }
}
