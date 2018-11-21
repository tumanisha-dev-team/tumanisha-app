<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Enums\Religion;

class EmployeeController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}
    function riders(){
    	return view('dashboard.employees.riders');
    }

    function newRider(){
    	$data['religions'] = Religion::toSelectArray();
    	return view('dashboard.employees.newrider')->with($data);
    }
}
