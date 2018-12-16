<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

use Carbon\Carbon;

class Invoice extends Model
{
		use LogsActivity;
		protected $my_date_format = 'Y-m-d';
    protected $fillable = ['invoice_no', 'from', 'to', 'amount', 'tax', 'uploaded_by', 'status', 'invoice_file_url', 'invoice_date'];
		protected static $logAttributes = ['*'];
    public function user(){
    	return $this->belongsTo('App\User', 'uploaded_by', 'id');
    }

    public function setFromAttribute($value){
    	$this->attributes['from'] = Carbon::parse($value)->format($this->my_date_format);
    }

    public function setToAttribute($value){
		$this->attributes['to'] = Carbon::parse($value)->format($this->my_date_format);
    }

    public function setInvoiceDateAttribute($value){
    	$this->attributes['invoice_date'] = Carbon::parse($value)->format($this->my_date_format);
    }
}
