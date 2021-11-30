<?php

namespace App\Models\CQC\Carehome;

use App\Models\Staff\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $table = 'carehome_notes';

    protected $fillable = ['location_id', 'staff_id', 'notes', 'deleted'];

    public function createNote($request, $id)
    {
        $this->location_id = $id;
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
