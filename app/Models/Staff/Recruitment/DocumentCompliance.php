<?php

namespace App\Models\Staff\Recruitment;

use Illuminate\Database\Eloquent\Model;

class DocumentCompliance extends Model
{
    //protected $table = 'c';
    protected $table = 'document_compliance';

    protected $fillable = [
        'applicant_id',
        'document_id',
        'filename',
        'url'
    ];

    protected $appends = ['type'];

    public function document()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Compliance', 'document_id');
    }

    public function getTypeAttribute()
    {
        return Compliance::where('id', $this->attributes['document_id'])->value('type');
    }

    public function getNameAttribute()
    {
        return Compliance::where('id', $this->attributes['name'])->value('name');
    }
}
