<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\SmsLog;
use App\Models\Staff\Recruitment\SmsTemp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommunicationController extends Controller
{
    public function get_template()
    {
        $data = SmsTemp::where('deleted_at','0')->get();
        // dd($data);
        return response()->json($data, 200);
    }

    public function get_dsecreption(Request $request)
    {

        $t_data = SmsTemp::where('id',$request->id)->first();
        return response()->json($t_data, 200);
        //dd($data);

    }

    public function sendMsg(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'msg' => 'required|string|min:15|max:50',
            'number' => 'required|digits:12',

        ],
            );

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }else {

            $message = $request->msg;
            $ph_num = $request->number;
            $snd = "Cavalry Health LTD";

            // Account details
            $apiKey = urlencode('NGQ0ZTYzNTA0NTM5NjQ1MjQyNmQ2MzQ1NDU2YzRkNTY=');

            //Message details
            $numbers = $ph_num;
            $sender = $snd;
            $message = $message;
            // Prepare data for POST request
            $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message, "test" => true);

            // Send the POST request with cURL
            $ch = curl_init('https://api.txtlocal.com/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $dr = json_decode($response, TRUE);
            $log = new SmsLog;
            $log->createlog($dr);

            // Process your response here
            return response()->json(['message' => 'The msg has been send'], 200);

        }
    }
}
