<?php

namespace App\Models\Compliance\Document;

use App\Models\Compliance\CompletedAudit\Upload as Completed;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'audit_groups';

    protected $fillable = [
        'name',
    ];

    public function createGroup($request)
    {
        $this->name = $request->name;
        $this->save();
        return $this;
    }

    public function audits()
    {
        return $this->hasMany('App\Models\Compliance\Document\Audit');
    }
}
