<?php

namespace App\Models\Compliance;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Procedures extends Model
{
    protected $table = 'audit_procedures';

    protected $fillable = [
        'display_name',
        'filename',
        'url',
        'deleted',
    ];
}
