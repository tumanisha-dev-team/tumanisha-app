<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RiderNextOfKin extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected $fillable = [
    	'riders_id',
		'name',
		'contact'
    ];

    public function rider(){
    	return $this->belongsTo('App\Rider');
    }
}
