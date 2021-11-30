<?php

namespace App\Models\CQC\Carehome;

use App\Models\CQC\Carehome;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinates extends Model
{
    use HasFactory;

    protected $table = 'carehome_coordinates';

    protected $fillable = ['location_id', 'lat', 'lng'];

    public function carehome()
    {
        return $this->belongsTo(Carehome::class, 'location_id', 'location_id');
    }
}
