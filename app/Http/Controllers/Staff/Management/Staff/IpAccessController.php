<?php

namespace App\Http\Controllers\Staff\Management\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff\User\Authorise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff\User\User;
use DB;

class IpAccessController extends Controller
{
    public function all_user(){


        $dat = DB::table('users_authorised_ips')
            ->join('users', 'users_authorised_ips.user_id', '=', 'users.id')
            ->select('users_authorised_ips.*','users_authorised_ips.id as cc', 'users_authorised_ips.ip', 'users_authorised_ips.deleted_at','users_authorised_ips.last_login as ltlg','users_authorised_ips.user_id as ccuid', 'users.id','users.name','users.verified' )
            ->orderBy('cc','DESC')->get();


        return response()->json($dat, 200);


    }

    public function user_ip_update(Request $request, $id){

        $user_id = Authorise::where('id', $id)->firstOrFail();
        $validator = Validator::make(request()->all(), [
            'user_ip' => 'required|ip',

        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
        $user_id->update(['ip' => $request->user_ip]);
        return response()->json(['message' => 'The staff account has been updated'], 200);



    }

    public function delete_user_ip($id)
    {
        Authorise::where('id', $id)->firstOrFail()->softDelete();
        return response()->json(['message' => 'The staff IP has been deactivated'], 200);
    }

    public function reset_user_ip($id)
    {
        //dd($id);
        Authorise::where('id', $id)->update(['deleted_at' => '0']);
        return response()->json(['message' => 'The staff IP has been activated'], 200);
    }

    public function create_ip(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id.value' => 'required',
            'ip' => 'required|ip',
        ],
            [ 'id.value.required' => 'Please select Active Staff name ', 'ip.required' => 'Please enter IP Address ' ],
        );

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
        {
            $new_ip = new Authorise;
            $new_ip->create_new_ip($request);
            return response()->json(['message' => 'The staff IP created successfully'], 200);

        }
    }
}
