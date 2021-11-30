<?php

namespace App\Http\Controllers\ITSupport;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff\Recruitment\Application;

class ContactController extends Controller
{
    const LIVE = false; // change to true before commiting
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';

    public function store(Request $request)
    {
        $form = $request->all();
        $validator = Validator::make($form, ['file' => 'required|mimes:jpg,png,jpeg|max:2048']);
        if ($validator->fails()) {
            return response()->json(['message' => 'Please enter image with png or jpg format'], 401);
        }

        if ($files = $form['file']) {
                $image_name = md5(rand(1000, 10000));
                $ext = strtolower($files->getClientOriginalExtension());
                $image_full_name = $image_name . '.' . $ext;
                $upload_path = 'public/attachment/';
                $files->move($upload_path, $image_full_name);
        }

        $files = array();
        $files[] = public_path('public/attachment/'.$image_full_name);


        if (isset($form)) {
            $sender_email = $form['email'];
            $sender_name = $form['name'];
            $subject = strtoupper($form['issue'] . ' submitted by ' . ucwords($sender_name));
            if (!strpos($sender_email, '@cavalrycare.co.uk')) {
                return response()->json([
                    'message' => 'Please use your @cavalrycare email to log this ticket'
                ], 402);
            }

            if ($form['issue'] == 'Request a new feature') {
                Mail::send('mail.support.feature', ['form' => $form], function ($message) use ($sender_email, $sender_name, $files, $subject) {
                    $message->from($sender_email);
                    foreach ($files as $file){
                        $message->attach($file);
                    }
                    if (self::LIVE) {
                        $message->to('isaac@warrantywise.co.uk')->subject($subject);
                    }
                    $message->to(self::TEST_EMAIL)->subject($subject);
                });
            } else {
                Mail::send('mail.support.problem', ['form' => $form], function ($message) use ($sender_email, $sender_name, $subject, $files) {
                    $message->from($sender_email);
                    foreach ($files as $file){
                        $message->attach($file);
                    }
                    if (self::LIVE) {
                        $message->to('isaac@warrantywise.co.uk')->subject($subject);
                    }
                    $message->to(self::TEST_EMAIL)->subject($subject);
                });
            }
            return response()->json([
                'message' => 'Ticket submitted'
            ], 201);
        }
        return response()->json([
            'message' => 'Please check nothing has been missed or incorrectly inputted'
        ], 402);
    }

    public function cv_parse(Request $request) {


        $files = $request->file('file');
        //dd($files->pathname);
        $filepath = $files;
        $handle = fopen($filepath, "r");
        $contents = fread($handle, filesize($filepath));
        fclose($handle);
        $modifiedDate = date("Y-m-d", filemtime($filepath));
//encode to base64
        $base64str = base64_encode($contents);

        $data = ["DocumentAsBase64String" => $base64str, "DocumentLastModified" => $modifiedDate];
//other options here (see https://sovren.com/technical-specs/latest/rest-api/resume-parser/api/)

//use https://eu-rest.resumeparsing.com/v10/parser/resume if your account is in the EU data center or
//use https://au-rest.resumeparsing.com/v10/parser/resume if your account is in the AU data center
        $url = "https://au-rest.resumeparsing.com/v10/parser/resume";

//setup curl to make the REST call, you can use an external library
//such as Guzzle if you prefer: http://guzzle.readthedocs.io
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $headers = [
            "accept: application/json",
            "content-type: application/json; charset=utf-8",
            "sovren-accountid: 98752817",
            "sovren-servicekey: lYNjciuLg4ntv/Z5sICXpVMNrj0BdxokKZGGb5S9"
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        curl_close($curl);
        $dr = json_decode($result, TRUE);

        $args = [];
        foreach ($dr as $c_t) {
            $detail_contect_info = $c_t;
        }

        foreach($detail_contect_info['ResumeData']['ContactInformation']['Telephones'] as $contact_info){

            $contact = $contact_info;
        }
        foreach($detail_contect_info['ResumeData']['ContactInformation']['EmailAddresses'] as $email_info){

            $email = $email_info;
        }
        $candidate_address = array();
        foreach($detail_contect_info['ResumeData']['ContactInformation']['Location'] as $current_location){

            $candidate_addres = $current_location;
        }
       $name =  $detail_contect_info['ResumeData']['ContactInformation']['CandidateName']['FormattedName'];
       $email =  $email;
       $contact_info =  $contact['Raw'];


        $new_ip = new Application();
        $new_ip->first_name = $name;
        $new_ip->email = $email;
        $new_ip->mobile = $contact_info;
        $new_ip->test = '1';
        $new_ip->save();


        return response()->json([
            'data' => $dr
        ], 200);


    }
}
