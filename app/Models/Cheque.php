<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Structure {
    protected $primaryKey = 'id';
    protected $table = 'cheques';
    protected $fillable = array('bank_id', 'lower_number', 'higher_number', 'status', 'total_number');
}
