<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'disbursements';
    protected $fillable = array('user_id', 'loan_id', 'type_id', 'date');
}