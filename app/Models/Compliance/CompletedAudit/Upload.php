<?php

namespace App\Models\Compliance\CompletedAudit;

use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'audits_completed';

    protected $fillable = [
        'staff_id',
        'audit_id',
        'display_name',
        'filename',
        'url',
        'score',
    ];

    public function getStaffIdAttribute()
    {
        return User::where('id', $this->attributes['staff_id'])->value('name');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y');
    }

    public function viewers()
    {
        return $this->hasMany('App\Models\Compliance\CompletedAudit\Viewer', 'completed_audit_id', 'id');
    }

    public function audit()
    {
        return $this->belongsTo('App\Models\Compliance\Document\Audit');
    }

}
