<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Enums\ReportStatus;

class AssetTrackerReport extends Model
{
    protected $fillable = ["assets_id", "report_date", "status", "description"];


    public function getStatusAttribute($value){
    	return ReportStatus::getKey($value);
    }

    public function getReportDateAttribute($value){
    	return \Carbon\Carbon::parse($value)->format('M d, Y');
    }

    public function getCreatedAtAttribute($value){
    	return \Carbon\Carbon::parse($value)->format('M d, Y h:i a');
    }
}
