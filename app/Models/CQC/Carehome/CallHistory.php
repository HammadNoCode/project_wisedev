<?php

namespace App\Models\CQC\Carehome;

use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallHistory extends Model
{
    use HasFactory;

    protected $table = 'carehome_call_history';

    protected $fillable = ['location_id', 'staff_id', 'spoke_to', 'position', 'decision_maker', 'notes'];

    public function createCallRecord($id)
    {
        $this->location_id = $id;
        $this->staff_id = session('staff_id');
        $this->save();
        return $this;
    }

    public function getStaffIdAttribute()
    {
        return User::where('id', $this->attributes['staff_id'])->value('name');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y H:i a');
    }
}
