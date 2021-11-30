<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Traits\ExternalCareerPageApi\ExternalCareerPageApiCvKey;




class CareersDataController extends Controller
{

    private $career;
    private $status_codes;
    private $response;

    public function __construct(){
        $career_data = new ExternalCareerPageApiCvKey();
        $this->career = $career_data;
        $this->status_codes = config('httpcodes');
        $this->response = config('responsemassages');

    }

    public function PostData(Request $request)
    {
        if (!empty($request->name && $request->email && $request->phone && $request->file('file'))) {

                $this->career->data($request);

            return response()->json(['message' =>$this->response['success'] ], $this->status_codes['success']);

        } elseif (!empty($request->email && $request->file('file') && $request->data_parse === '1')) {
                $this->career->cv_parsing($request);

            return response()->json(['message' => 'applicant submitted created through cv parsing'], 200);

        } else {

            return response()->json(['message' => $this->response['incomplete_form']],$this->status_codes['incomplete_form']);

        }

    }
    }
