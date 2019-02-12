<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderDeactivation extends Model
{
    protected $fillable = [
    	'rider_id',
		'from',
		'to',
		'deactivated_by'
    ];

    public function rider(){
    	return $this->belongsTo('\App\Rider', 'rider_id', 'id');
    }

    public function userResponsible(){
    	return $this->belongsTo('\App\User', 'deactivated_by', 'id');
    }
}
