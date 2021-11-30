<?php

namespace App\Models\CQC\Carehome\Onboarding;

use App\Models\CQC\Carehome;
use App\Traits\Reports\RangeFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedStages extends Model
{
    use HasFactory;

    use RangeFilter;

    protected $table = 'carehome_onboarding_completed_stages';

    protected $fillable = ['location_id', 'stage_id', 'checked_by'];

    public function carehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id');
    }

    public function blackburnCarehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id')->where('branch_id', 1);
    }

    public function liverpoolCarehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id')->where('branch_id', 2);
    }

    public function warringtonCarehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id')->where('branch_id', 3);
    }

    public function creweCarehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id')->where('branch_id', 4);
    }

    public function scopeVisitPeriod($query, $from, $to)
	{
		return $to
			? $query->where('created_at', '>=', $from)->where('created_at', '<', $to)
			: $query->where('created_at', '>=', $from);
	}
}
