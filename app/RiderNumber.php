<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderNumber extends Model
{
    protected $fillable = ['employee_id', 'orders', 'orders_date', 'comments'];

    public function Rider(){
    	return $this->belongsTo('\App\Rider', 'employee_id', 'id');
    }
}
