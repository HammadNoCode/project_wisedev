<?php

namespace App\Http\Controllers\StaffOffboarding;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->all();
        Mail::send('mail.staffOffboarding.email', ['data' => $data], function ($message) {
            $message->to('isaac@warrantywise.co.uk')->subject('Offboarding');
        });
        return response()->json(
            [
                'message' => 'Submit success'
            ],
            200
        );
    }
}
