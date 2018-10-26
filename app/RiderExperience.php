<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderExperience extends Model
{
    protected $fillable = [
    	'riders_id',
		'company_name',
		'role',
    ];

    public function rider(){
    	return $this->belongsTo('App\Rider');
    }

    public function referees(){
    	return $this->hasMany('App\RiderExperienceReferee');
    }
}
