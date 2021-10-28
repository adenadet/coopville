<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'shares';
    protected $fillable = array('type_id', 'user_id', 'balance', 'requested_date', 'requested_by', 'status', 'admin_id', 'status_date');
	}