<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiderNextOfKin extends Model
{
    protected $fillable = [
    	'riders_id',
		'name',
		'contact'
    ];

    public function rider(){
    	return $this->belongsTo('App\Rider');
    }
}
