<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\RiderNumber;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['totalOrders'] = RiderNumber::sum('orders');
        $data['thisMonthOrders'] = RiderNumber::whereBetween('orders_date', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->sum('orders');
        $data['lastMonthNumbers'] = RiderNumber::whereBetween('orders_date', [(new Carbon('first day of last month'))->format('Y-m-d'), (new Carbon('last day of last month'))->format('Y-m-d')])->sum('orders');
        return view('home')->with($data);
    }
}
