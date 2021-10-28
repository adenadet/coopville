<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareType extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'share_types';
    protected $fillable = array('name', 'rate', 'lower_limit', 'upper_limit', 'compounding', 'duration');
	}