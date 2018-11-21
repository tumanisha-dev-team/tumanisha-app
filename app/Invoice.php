<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Invoice extends Model
{
	protected $dateFormat = 'Y-m-d';
    protected $fillable = ['invoice_no', 'from', 'to', 'amount', 'tax', 'uploaded_by', 'status', 'invoice_file_url', 'invoice_date'];

    public function user(){
    	return $this->belongsTo('App\User', 'uploaded_by', 'id');
    }

    public function setFromAttribute($value){
    	$this->attributes['from'] = new Carbon($value);
    }

    public function setToAttribute($value){
		$this->attributes['to'] = new Carbon($value);
    }

    public function setInvoiceDateAttribute($value){
    	$this->attributes['invoice_date'] = new Carbon($value);
    }
}
