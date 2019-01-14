<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class UserController extends Controller
{
    function index(){
    	$data['users'] = User::all();
		return view('dashboard.users.index')->with($data);
	}
}
