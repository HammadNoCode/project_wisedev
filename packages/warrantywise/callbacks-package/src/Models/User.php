<?php

namespace Callbacks\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;


class User extends Model
{
    protected $connection = 'staff';
    protected $table = 'users';

    public function __construct()
	{
		switch(Route::current()->getDomain()){
			case env('STAFF_URL'):
				$this->setConnection('staff');
				break;
			default:
				$this->setConnection('core');
		}
	}
}
