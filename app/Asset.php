<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ["company_id", "registration_no", "log_book_no", "chassis_no", "color", "asset_type", "date_purchased", "model", "engine_no", "make", "invoice_no", "engine_body", "dealer"];
}
