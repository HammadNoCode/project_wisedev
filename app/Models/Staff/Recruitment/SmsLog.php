<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $table = 'sms_log';

    protected $fillable = ['status','message','recipient','batch_id'];

    public function createlog($dr)
    {
        $drt = $dr['message']['content'];
        $this->batch_id = $dr['batch_id'];
        $this->status = $dr['status'];
        $this->message = $drt;
        $this->recipient = $dr['num_messages'];
        $this->save();
        return  $this;

    }

}
