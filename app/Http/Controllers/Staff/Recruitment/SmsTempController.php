<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\SmsLog;
use App\Models\Staff\User\Authorise;
use App\Models\Staff\Recruitment\SmsTemp;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SmsTempController extends Controller
{
    public function create_temp(Request $request){

        {

            $validator = Validator::make(request()->all(), [
                't_name' => 'required|max:15',
                't_descp' => 'required||max:200',

            ],
                ['t_name.required' => 'Please enter template name ', 't_descp.required' => 'Please enter description '],
            );


            if ($validator->fails()) {
                return response()->json(['message' => $validator->errors()->first()], 401);
            }

            {
                $new_ip = new SmsTemp();
                $new_ip->template_name = $request->t_name;
                $new_ip->t_description = $request->t_descp;
                $new_ip->deleted_at = '0';
                $new_ip->save();

                return response()->json([
                    'message' => 'The Sms Template created successfully'
                ], 200);

            }


        }
    }
    public function get_temp()
    {
        $data = SmsTemp::orderBy('id', 'DESC')->get();
        return response()->json($data, 200);
    }

    public function destroy($id){

        SmsTemp::where('id', $id)->firstOrFail()->softDelete();
        return response()->json(['message' => 'The Sms Template has been deactivated'], 200);

    }


    public function update($id){

        SmsTemp::where(['id' => $id])->update(['deleted_at' => '0']);
        return response()->json(['message' => 'The Sms Template has been activated'], 200);

    }

    public function getlog(){

        $log_data = SmsLog::orderBy('id','DESC')->get();
        return response()->json($log_data, 200);

    }
}
