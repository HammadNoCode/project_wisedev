<?php

namespace App\Models\CQC\Carehome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialism extends Model
{
    use HasFactory;

    protected $table = 'carehome_specialisms';

    protected $fillable = ['location_id', 'specialism'];
}
