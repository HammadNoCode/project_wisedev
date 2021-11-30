<?php

namespace App\Models\Branch;

use App\Models\Staff\User\Branches;
use App\Traits\Reports\RangeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    use RangeFilter;

    protected $table = 'branch_reporting';

    protected $fillable = [
        'branch_id', 'poistion', 'hours_achieved', 'hours_lost', 'week_commencing', 'weeking_ending'
    ];

    public function createReport($request)
    {
        $s = Branches::where('name', $request->input('branch'))->first();
        //dd($s);
        $this->branch_id = $s['id'];
        $this->position = $request->data['position'];
        $this->hours_achieved = $request->data['hours_achieved'];
        $this->hours_lost = $request->data['hours_lost'];
        $this->week_commencing = $request->data['week_commencing'];
        $this->week_ending = $request->data['week_ending'];
        $this->save();
        return $this;
    }

    public function scopeVisitPeriod($query, $from, $to)
    {
        return $to
            ? $query->where('week_commencing', '>=', $from)->where('week_ending', '<=', $to)
            : $query->where('week_commencing', '>=', $from);
    }
}
