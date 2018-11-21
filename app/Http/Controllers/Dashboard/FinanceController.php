<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    function __construct()
	{
		$this->middleware('auth');
	}

	function withdrawals(){
		return view('dashboard.finance.withdrawal');
	}
}
