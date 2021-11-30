<?php

namespace App\Models\Staff\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Staff\Base;

/**
 * @property mixed $verified
 * @property mixed $deleted
 * @property mixed $position
 * @property mixed $telephone
 */

class User extends Base
{
    protected $table = 'users';

    protected $fillable = ['department', 'manager', 'branch_id'];

    protected $hidden = ['password'];

    protected $appends = ['last_login', 'account_type'];

    public function verify()
    {
        $this->verified = 1;
        $this->save();
        return $this;
    }

    public function softDelete()
    {
        $this->deleted = 1;
        $this->save();
        return $this;
    }

    public function updatePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();
        return $this;
    }

    public function updateProfile($form)
    {
        $this->position = $form['position'] ?? $this->position;
        $this->email = $form['email'] ?? $this->email;
        $this->telephone = $form['telephone'] ?? $this->telephone;
        $this->save();
        return $this;
    }

    public function getAccountTypeAttribute()
    {
        return 1;
    }

    public function getDepartmentArrayAttribute()
    {
        return isset($this->attributes['department_array']) ? Department::where('id', $this->attributes['department_array'])->first() : (object) [];
    }


    public function getLastLoginAttribute()
    {
        if (isset($this->updated_at)) {
            return $this->updated_at->format('d/m/y H:i');
        }
    }

    public function ip_access(){

        return $this->hasMany(Authorise::class, 'id','user_id');

    }

}
