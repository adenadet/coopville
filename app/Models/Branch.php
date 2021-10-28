<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'branches';
    protected $fillable = array('name', 'location', 'unique_id', 'current', 'status');
	
    public function users(){
    	return $this->hasMany('App\Models\User', 'branch_id', 'id');
		}
	public function branch_admins(){
		
		}
	}