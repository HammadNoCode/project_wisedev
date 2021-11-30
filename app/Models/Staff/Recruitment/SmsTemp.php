<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTemp extends Model
{
    use HasFactory;

    protected $table = 'sms_template';

    protected $fillable = ['template_name','t_description','last_login'];

    public function softDelete()
    {
        $this->deleted_at = 1;
        $this->save();
        return $this;
    }
}
