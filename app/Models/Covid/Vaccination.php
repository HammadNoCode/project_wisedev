<?php

namespace App\Models\Covid;

use App\Models\Staff\Base;
use App\Models\Staff\Recruitment\Application;

class Vaccination extends Base
{
  protected $table = 'vaccinations';

  /**
   * Application form relationship
   *
   * @return void
   */
  public function application()
  {
    return $this->belongsTo(Application::class, 'staff_id', 'id');
  }

  public function scopeArchived($query, $archived)
  {
    switch ($archived) {
      case ('yes'):
        return $query->where('archived', 1);
      case ('no'):
        return $query->where('archived', 0);
    }
  }

  public function scopeSearch($query, $search)
  {
    return $query->where(function ($querys) use ($search) {
      $querys->orWhere("last_name", 'LIKE', "%{$search}%");
    });
  }

  public function vaccination()
  {
    return $this->hasMany(Vaccination::class, 'staff_id', 'staff_id');
  }
}
