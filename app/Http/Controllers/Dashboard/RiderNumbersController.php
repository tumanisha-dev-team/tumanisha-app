<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rider;
use App\RiderNumber;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class RiderNumbersController extends Controller
{
    function index(){
    	return view('dashboard.employees.riders.numbers');
    }

    function riderSummary(){
    	$today = (new Carbon())->addDay(1);

    	$first_day_month = new Carbon('first day of this month');

    	$rider_numbers = RiderNumber::whereBetween('orders_date', [$first_day_month, $today])->get();
    	$data['this_month_numbers'] = $rider_numbers;
    	$data['period'] = CarbonPeriod::create($first_day_month, $today);
    	return view('dashboard.employees.riders.numbers-summary')->with($data);
    }
}
