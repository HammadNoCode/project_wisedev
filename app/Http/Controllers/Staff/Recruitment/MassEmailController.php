<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class MassEmailController extends Controller
{
    /**
     * Index function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $data = Application::status($request->status)
            ->branch($request->branch)
            ->position($request->role)
            ->where('test', '!=', 1)
            ->select('branch_id', 'position', 'first_name', 'last_name', 'email', 'status')
            ->paginate(15);
        return response()->json($data, 200);
    }

    /**
     * Send email function.
     *
     * @param Request $request
     * @return void
     */
    public function sendMail(Request $request)
    {
        $data = Application::status($request->filters['status'])
            ->branch($request->filters['branch'])
            ->position($request->filters['role'])
            ->where('test', '!=', 1)
            ->take(1)
            ->get();

        switch ($request->filters['role']) {
            case ('Healthcare Assistant'):
                $template = 'mail.recruitment.hca';
                break;
            case ('Senior Healthcare Assistant'):
                $template = 'mail.recruitment.shca';
                break;
            case ('RMN'):
                $template = 'mail.recruitment.nurse';
                break;
            case ('RGN'):
                $template = 'mail.recruitment.nurse';
                break;
            case ('Support Worker'):
                $template = 'mail.recruitment.complex-care';
                break;
        }

        foreach ($data as $recipient) {
            $mailData = $recipient->toArray();
            Mail::send($template, $mailData, function ($message) use ($mailData) {
                $message->from('join@cavalrycare.co.uk');
                $message->to($mailData['email'], $mailData['first_name'])->subject('no subject');
            });
        }

        return response()->json(['message' => 'Emails sent'], 200);
    }
}
