<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RiderExperience extends Model
{
    use LogsActivity;
    protected $fillable = [
      	'riders_id',
    		'company_name',
    		'role',
    ];

    protected static $logAttributes = ['*'];

    public function rider(){
    	return $this->belongsTo('App\Rider');
    }

    public function referees(){
    	return $this->hasMany('App\RiderExperienceReferee');
    }
}
