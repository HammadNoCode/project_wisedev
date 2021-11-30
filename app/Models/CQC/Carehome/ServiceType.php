<?php

namespace App\Models\CQC\Carehome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;

    protected $table = 'carehome_service_types';

    protected $fillable = ['location_id', 'type', 'description'];
}
