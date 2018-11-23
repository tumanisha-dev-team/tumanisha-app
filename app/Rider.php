<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
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
		'license_url'
    ];

    public function work_experiences(){
    	return $this->hasMany('App\RiderExperience');
    }

    public function next_of_kin(){
    	return $this->hasMany('App\RiderNextOfKin');
    }

    public function getRiderAvatarAttribute(){
    	return ($this->photo_url) ? \Storage::url($this->photo_url) : '/dashboard/img/profile-photos/2.png';
    }
}
