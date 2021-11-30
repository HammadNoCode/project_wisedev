<?php

namespace App\Models\Compliance\Document;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Audit extends Model
{
    protected $table = 'audits';

    protected $fillable = [
        'group_id',
        'display_name',
        'filename',
        'url',
        'weight',
        'max_score',
        'deleted'
    ];

    public function completed_audits()
    {
        return $this->hasMany('App\Models\Compliance\CompletedAudit\Upload', 'audit_id', 'id');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M, Y');
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Compliance\Document\Group');
    }
}
