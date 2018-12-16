<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RiderNumber extends Model
{
    use LogsActivity;

    protected $fillable = ['employee_id', 'orders', 'orders_date', 'comments'];
    protected static $logAttributes = ['*'];

    public function Rider(){
    	return $this->belongsTo('\App\Rider', 'employee_id', 'id');
    }
}
