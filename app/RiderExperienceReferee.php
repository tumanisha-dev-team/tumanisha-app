<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderExperienceReferee extends Model
{
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
