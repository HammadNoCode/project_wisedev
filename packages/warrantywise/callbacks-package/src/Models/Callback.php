<?php

namespace Callbacks\Models;

use Callbacks\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
	protected $connection = 'staff';

	protected $table = 'call_schedule';

	protected $fillable = [
		'staff_id',
		'path',
		'outcome',
		'scheduled',
		'title'
	];

	protected $casts = [
		'scheduled'  => 'date:Y-m-d H:i:s'
	];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);
		switch (Route::current()->getDomain()) {
			case env('STAFF_URL'):
				$this->setConnection('staff');
				break;
			default:
				$this->setConnection('core');
		}
	}

	public function user()
	{
		return $this->hasOne(User::class, 'id', 'staff_id');
	}
}
