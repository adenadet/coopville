<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sharing extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'sharings';
    protected $fillable = array('user_id', 'payment_channel', 'amount', 'status', 'logged_by', 'logged_date', 'confirmed_date', 'confirmed_by', 'payment_date', 'description', 'share_id');
	}