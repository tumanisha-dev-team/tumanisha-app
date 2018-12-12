<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rider;
use App\riderNumbers;

class RiderController extends Controller
{
    function index(){
    	return Rider::all();
    }

    function getRidersOrderByDate($date){
    	$date = \Carbon\Carbon::parse($date)->format('Y-m-d');
    	$riderNumbers = \DB::table('riders')
    					->select('riders.id', 'riders.first_name', 'riders.last_name', 'riders.photo_url', \DB::raw('rider_numbers.id AS orders_id'), 'rider_numbers.orders', 'rider_numbers.orders_date', 'rider_numbers.comments')
    					->leftJoin('rider_numbers', function($join) use ($date){
    						$join->on('riders.id', '=', 'rider_numbers.employee_id')
    						->where('rider_numbers.orders_date', '=', $date);
    					})
    					->get();

    	return $riderNumbers;
    }

    function storeOrders(Request $request){
    	$data = [];
    	foreach($request->input('id') as $k => $id){
    		$data[] = [
    			'id'			=>	$id,
    			'orders'		=>	$request->orders[$k],
    			'comment'		=>	$request->comments[$k],
    			'orders_id'		=>	$request->orders_id[$k],
    			'orders_date'	=>	$request->orders_date
    		];
    	}

    	return $data;
    }
}
