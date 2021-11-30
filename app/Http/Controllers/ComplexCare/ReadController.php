<?php

namespace App\Http\Controllers\ComplexCare;

use App\Http\Controllers\Controller;
use App\Models\ComplexCare\Competency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReadController extends Controller
{
    public function show(Request $request)
    {
        $searched = $this->search($request->search);
        $data = $searched->select('*')->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($data, 200);
    }

    public function search($search)
    {
        return Competency::where(function ($query) use ($search) {
            $query->orWhere("nurse_name", 'LIKE', "%{$search}%");
            $query->orWhere("staff_name", 'LIKE', "%{$search}%");
        });
    }

    public function get_form($staffname, $filename)
    {
        return Storage::disk('s3Competence')->response('Complex-care/Competencies/' . $staffname  . '/' . $filename);
    }
}
