<?php

namespace App\Models\Staff\Recruitment\Application;

use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class Invite extends Model
{
    use HasFactory;

    use \Awobaz\Compoships\Compoships;

    protected $table = 'application_invites';

    protected $fillable = [
        'position',
        'first_name',
        'last_name',
        'email',
        'telephone',
        'address_line_1',
        'address_line_2',
        'city',
        'postcode',
        'hours_pw',
        'driving_licence',
        '24hr_reminder',
        'token',
        'referral',
        'referred_by',
    ];

    protected $date = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relationships
     *
     * @return void
     */
    public function application()
    {
        return $this->hasOne(Application::class, 'invite_token', 'token');
    }

    /**
     * get staff names attribute
     *
     * @return void
     */
    public function getUsernameAttribute()
    {
        return User::where('id', $this->attributes['referred_by'])->value('name');
    }

    public function createInvite($request, $referred_by)
    {
        $this->position = $request->position;
        $this->first_name = $request->first_name;
        $this->last_name = $request->last_name;
        $this->email = $request->email;
        $this->telephone = $request->telephone;
        $this->address_line_1 = $request->address_line_1;
        $this->address_line_2 = $request->address_line_2;
        $this->city = $request->city;
        $this->postcode = $request->postcode;
        $this->hours_pw = $request->hours_pw;
        $this->driving_licence = $request->driving_licence;
        $this->source = $request->source;
        $this->referral = $request->referral;
        $this->referred_by = $referred_by;
        $this->token = Str::random(16);
        $this->save();
        return $this;
    }
}
