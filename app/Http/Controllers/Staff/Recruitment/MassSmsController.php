<?php
namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff\Recruitment\SmsLog;


class MassSmsController extends Controller
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
            ->select('branch_id', 'position', 'first_name', 'last_name', 'email', 'status', 'mobile')
            ->paginate(15);
        return response()->json($data, 200);
    }

    /**
     * Send email function.
     *
     * @param Request $request
     * @return void
     */

    public function sendSms(Request $request)
    {
        $itm = $request->all();
        $desc = $itm['filters'];

        $rules = ['filters.section' => 'required|max:50'];
        $attributeNames = array(
            'filters.section' => 'msg description',

        );
        $validator = Validator::make($itm, $rules);
        $validator->setAttributeNames($attributeNames);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        $data = Application::status($request->filters['status'])
            ->branch($request->filters['branch'])
            ->position($request->filters['role'])
            ->where('test', '!=', 1)
            ->get();
        $mb_data = array();
        foreach ($data as $data_itm) {
            $mb_data[] = $data_itm->mobile;
        }
        $numbers = implode(',', $mb_data);
        $msg = $desc['section'];
       // dd($msg);
        $ph_num = $numbers;
        $snd = "Cavalry Health LTD";

        // Account details
        $apiKey = urlencode('NGQ0ZTYzNTA0NTM5NjQ1MjQyNmQ2MzQ1NDU2YzRkNTY=');

        //Message details
        $numbers = $ph_num;
        $sender = $snd;
        $message = $msg;

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
        return response()->json(['message' => 'The sms has been send successfully'], 200);


    }

}
