<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Rider extends Model
{
    use LogsActivity;

    protected $fillable = [
		'first_name',
		'last_name',
		'national_id_no',
		'license_no',
		'kra_pin',
		'nhif_no',
		'date_of_birth',
		'gender',
		'nationality',
		'religion',
		'primary_phone_number',
		'secondary_phone_number',
		'email',
		'college_high_school',
		'primary_school',
		'height',
		'eye_color',
		'hair_color',
		'photo_url',
		'id_url',
		'license_url',
		'starting_date',
		'jumia_no'
    ];

    protected static $logAttributes = ['*'];

    public function orders(){
    	return $this->hasMany('App\RiderNumber', 'employee_id', 'id');
    }

    public function work_experiences(){
    	return $this->hasMany('App\RiderExperience');
    }

    public function next_of_kin(){
    	return $this->hasMany('App\RiderNextOfKin');
    }

    public function getRiderAvatarAttribute(){
    	return ($this->photo_url) ? route('rider-profile', $this->id) : '/dashboard/img/profile-photos/2.png';
    }

    public function getNameAttribute(){
      return "{$this->first_name} {$this->last_name}";
    }

	public function getStartingDateAttribute($value){
		return \Carbon\Carbon::parse($value)->format('F d, Y');
	}
}
