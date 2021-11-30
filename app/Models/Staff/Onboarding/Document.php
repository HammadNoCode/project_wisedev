<?php

namespace App\Models\Staff\Onboarding;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'staff_onboarding_documents';

    public function createDocument($id, $displayName)
    {
        $this->onboarding_id = $id;
        $this->display_name = $displayName;
        $this->save();
        return $this;
    }
}
