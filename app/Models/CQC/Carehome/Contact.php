<?php

namespace App\Models\CQC\Carehome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'carehome_contacts';

    protected $fillable = ['location_id', 'full_name', 'role', 'contact_number'];
}
