<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RiderExperienceReferee extends Model
{
    use LogsActivity;
    protected static $logAttributes = ['*'];
    protected $fillable = [
    	'rider_experiences_id',
		'referee_name',
		'referee_contact',
		'referee_email',
    ];

    public function work_experience(){
    	return $this->belongsTo('App\RiderExperience');
    }
}
