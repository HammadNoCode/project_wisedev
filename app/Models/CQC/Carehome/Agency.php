<?php

namespace App\Models\CQC\Carehome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'carehome_agencies';

    protected $fillable = ['location_id', 'name'];

    public function createAgency($request)
    {
        $this->location_id = $request->id;
        $this->name = $request->name;
        $this->save();
        return $this;
    }
}
