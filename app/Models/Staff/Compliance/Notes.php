<?php

namespace App\Models\Staff\Compliance;

use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $table = 'compliance_notes';

    protected $fillable = ['applicant_id', 'staff_id', 'notes'];

    public function createNote($request, $id)
    {
        $this->applicant_id = $id;
        $this->staff_id = session('staff_id');
        $this->notes = $request->note;
        $this->save();
        return $this;
    }

    public function getStaffIdAttribute()
    {
        return User::where('id', $this->attributes['staff_id'])->value('name');
    }

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d-m-Y H:i');
    }
}
