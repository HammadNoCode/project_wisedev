<?php

namespace App\Models\Staff\Recruitment;

use App\Models\Staff\Base;
use App\Models\Staff\User\User;
use Carbon\Carbon;

/**
 * @property mixed $name
 * @property mixed $type
 * @property mixed $required
 * @property mixed $test
 */

class Compliance extends Base
{
    protected $table = 'compliance_documents';

    protected $fillable = [
        'name',
        'type',
        'required',
    ];

    public $appends = ['document_id'];

    public $casts = ['required' => 'boolean'];

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    public function compliance()
    {
        return $this->belongsTo('App\Models\Staff\Recruitment\Compliance', 'id');
    }

    public function completed_compliance()
    {
        return $this->hasMany('App\Models\Staff\Recruitment\ApplicantCompliance', 'document_id', 'id');
    }

    public function createDocument($request)
    {
        switch ($request->position) {
            case ('Healthcare Assistant'):
                $this->name = $request->name;
                $this->type = $request->type;
                $this->required = $request->required;
               // $this->test = $this->env();
                $this->test = 0;
                $this->ha = 1;
                $this->deleted = 0;
                $this->save();
                return $this;
                break;
            case ('Senior Healthcare Assistant'):
                $this->name = $request->name;
                $this->type = $request->type;
                $this->required = $request->required;
                //$this->test = $this->env();
                $this->test = 0;
                $this->sha = 1;
                $this->deleted = 0;
                $this->save();
                return $this;
                break;
            case ('Support Worker'):
                $this->name = $request->name;
                $this->type = $request->type;
                $this->required = $request->required;
              //  $this->test = $this->env();
                $this->test = 0;
                $this->ha = 1;
                $this->deleted = 0;
                $this->save();
                return $this;
                break;
            case ('RGN'):
                $this->name = $request->name;
                $this->type = $request->type;
                $this->required = $request->required;
               // $this->test = $this->env();
                $this->test = 0;
                $this->rgn = 1;
                $this->deleted = 0;
                $this->save();
                return $this;
                break;
            case ('RMN'):
                $this->name = $request->name;
                $this->type = $request->type;
                $this->required = $request->required;
             //   $this->test = $this->env();
                $this->test = 0;
                $this->rmn = 1;
                $this->deleted = 0;
                $this->save();
                return $this;
                break;
        }
    }

    public function getDocumentIdAttribute()
    {
        return ApplicantCompliance::where('document_id', $this->attributes['id'])->value('document_id');
    }

    public function scopeDocument($query, $position)
    {
        switch ($position) {
            case ('Healthcare Assistant'):
                $query->select('*')
                    ->where('type', 1)
                    ->where('ha', 1)
                    ->where('deleted', 0)
                    ->where('test', 0)
                    ->orderBy('name', 'desc');
                break;
            case ('Senior Healthcare Assistant'):
                $query->select('*')
                    ->where('type', 1)
                    ->where('sha', 1)
                    ->where('deleted', 0)
                    ->where('test', 0)
                    ->orderBy('name', 'desc');
                break;
            case ('Support Worker'):
                $query->select('*')
                    ->where('type', 1)
                    ->where('ha', 1)
                    ->where('deleted', 0)
                    ->where('test', 0)
                    ->orderBy('name', 'desc');
                break;
            case ('RGN'):
                $query->select('*')
                    ->where('type', 1)
                    ->where('rgn', 1)
                    ->where('deleted', 0)
                    ->where('test', 0)
                    ->orderBy('name', 'desc');
                break;
            case ('RMN'):
                $query->select('*')
                    ->where('type', 1)
                    ->where('rmn', 1)
                    ->where('deleted', 0)
                    ->where('test', 0)
                    ->orderBy('name', 'desc');
                break;

        }
    }
}
