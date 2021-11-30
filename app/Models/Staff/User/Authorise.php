<?php

namespace App\Models\Staff\User;

use App\Models\Staff\Base;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Authorise extends Base
{
    protected $table = 'users_authorised_ips';

    protected $fillable = ['updated_at','ip','last_login'];

    public function softDelete()
    {
        $this->deleted_at = 1;
        $this->save();
        return $this;
    }

    public function create_new_ip($request)
    {

        $this->user_id = (string)$request->id['value'];
        $this->ip = $request->ip;
        $this->deleted_at = '0';
        $this->save();
        return $this;


    }

    public static function last_login($request)
    {
        Authorise::where(['ip' => $request->getClientIp(),'user_id' => session()->get('staff_id')])
            ->update(['last_login' => Carbon::now('M d Y')]);
    }
}
