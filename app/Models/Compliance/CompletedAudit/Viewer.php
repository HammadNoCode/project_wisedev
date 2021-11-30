<?php

namespace App\Models\Compliance\CompletedAudit;

use App\Models\Compliance\Document\Audit;
use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Viewer extends Model
{
    protected $table = 'audits_completed_viewers';

    protected $fillable = [
        'completed_audit_id',
        'viewer_id',
    ];

    public function template()
    {
        return $this->belongsTo('App\Models\Compliance\Document\Audit', 'id');
    }

    public function getViewerIdAttribute()
    {
        return User::where('id', $this->attributes['viewer_id'])->value('name');
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('H:i, d M, Y');
    }

    public function getCompletedAuditIdAttribute()
    {
        return Audit::where('id', $this->attributes['completed_audit_id'])->value('display_name');
    }
}
