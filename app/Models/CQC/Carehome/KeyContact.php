<?php

namespace App\Models\CQC\Carehome;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyContact extends Model
{
    use HasFactory;

    protected $table = 'carehome_key_contacts';

    protected $fillable = ['location_id', 'first_name', 'last_name', 'contact_no', 'role'];

    public function createKeyContact($id, $request)
    {
        $this->location_id = $id;
        $this->first_name = $request->first_name;
        $this->last_name = $request->last_name;
        $this->contact_no = $request->contact_no;
        $this->save();
        return $this;
    }
}
