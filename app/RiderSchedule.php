<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

use Carbon\Carbon;

class RiderSchedule extends Model
{
    protected $fillable = ['rider_id', 'type', 'from', 'to', 'notes'];
    protected $my_date_format = 'Y-m-d';
    protected static $logAttributes = ['*'];

    public function setFromAttribute($value){
    	$this->attributes['from'] = Carbon::parse($value)->format($this->my_date_format);
    }

    public function setToAttribute($value){
		    $this->attributes['to'] = Carbon::parse($value)->format($this->my_date_format);
    }

    public function rider(){
        return $this->belongsTo('\App\Rider', 'rider_id', 'id');
    }
}
