<?php

namespace App\Models\CQC;

use App\Models\CQC\Carehome\Agency;
use App\Models\CQC\Carehome\Onboarding;
use App\Models\CQC\Carehome\Onboarding\CompletedStages;
use App\Models\CQC\Carehome\ServiceType;
use App\Models\CQC\Carehome\Specialism;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Reports\RangeFilter;

use function PHPSTORM_META\map;

class Carehome extends Model
{
    use RangeFilter;

    use HasFactory;

    protected $table = 'carehomes';

    protected $fillable = [
        'location_id',
        'provider_id',
        'name',
        'address_1',
        'city',
        'postal_code',
        'region',
        'main_contact_number',
        'beds',
        'rating',
        'website',
        'branch_id',
        'agency_status',
        'status',
        'favourited',
    ];

    public function specialisms()
    {
        return $this->hasMany(Specialism::class, 'location_id', 'location_id');
    }

    public function service_types()
    {
        return $this->hasMany(ServiceType::class, 'location_id', 'location_id');
    }

    public function agencies()
    {
        return $this->hasMany(Agency::class, 'location_id', 'location_id');
    }

    public function onboarding()
    {
        return $this->hasMany(CompletedStages::class, 'location_id', 'location_id');
    }

    public function notContacted()
    {
        return $this->hasMany(CompletedStages::class, 'location_id', 'location_id')->where('stage_id', 1);
    }

    public function visited()
    {
        return $this->hasMany(CompletedStages::class, 'location_id', 'location_id')->where('stage_id', 7);
    }

    public function scopeVisitPeriod($query, $from, $to)
    {
        return $to
            ? $query->where('created_at', '>=', $from)->where('created_at', '<', $to)
            : $query->where('created_at', '>=', $from);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($query) use ($search) {
            $query->orWhere("name", "LIKE", "%{$search}%");
            $query->orWhere("region", "LIKE", "%{$search}%");
        });
    }

    public function scopeFilter($query, $filter)
    {
        if ($filter == 'all') {
            return $query;
        } else {
            return $query->where('rating', $filter);
        }
    }

    public function scopeRange($query, $range)
    {
        switch ($range) {
            case ('all'):
                return $query;
            case ('0-20'):
                return $query->whereBetween('beds', [0, 20]);
            case ('21-40'):
                return $query->whereBetween('beds', [21, 40]);
            case ('41'):
                return $query->where('beds', '>=', 41);
        }
    }

    public function scopeBranch($query, $branch)
    {
        if ($branch == 'all') {
            return $query;
        } else {
            return $query->where('branch_id', $branch);
        }
    }

    public function scopeFavourited($query, $favourited)
    {
        switch ($favourited) {
            case ('all'):
                return $query;
            default:
                return $query->where('favourited', $favourited);
        }
    }
}
