<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'role_user';
    protected $fillable = array('user_id', 'role_id');
	}