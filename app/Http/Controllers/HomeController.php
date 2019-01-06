<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Rider;
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
        $data['lastMonthChampion'] = $this->getLastMonthChampion();
        $data['thisMonthChampion'] = $this->getThisMonthChampion();
        return view('home')->with($data);
    }

    public function getLastMonthChampion(){
        $lastMonth = new Carbon('first day of last month');
        $highestLastMonth = RiderNumber::select('employee_id', \DB::raw('SUM(orders) AS orders'))->whereBetween('orders_date', [$lastMonth->format('Y-m-d'), $lastMonth->endOfMonth()->format('Y-m-d')])->groupBy('employee_id')->orderBy(\DB::raw('SUM(orders)'), 'DESC')->first();
        return $highestLastMonth;
    }

    public function getThisMonthChampion(){
        $thisMonth = Carbon::now();
        $highestThisMonth = RiderNumber::select('employee_id', \DB::raw('SUM(orders) AS orders'))->whereBetween('orders_date', [$thisMonth->startOfMonth()->format('Y-m-d'), $thisMonth->endOfMonth()->format('Y-m-d')])->groupBy('employee_id')->orderBy(\DB::raw('SUM(orders)'), 'DESC')->first();
        if($highestThisMonth){
            return $highestThisMonth;
        }else{
            return null;
        }
    }
}
