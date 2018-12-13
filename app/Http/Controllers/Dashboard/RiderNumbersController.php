<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rider;
use App\RiderNumber;

class RiderNumbersController extends Controller
{
    function index(){
    	return view('dashboard.employees.riders.numbers');
    }
}
