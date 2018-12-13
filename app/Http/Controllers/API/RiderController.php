<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rider;
use App\RiderNumber;

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

      foreach ($data as $order) {
        $riderNumbers = new RiderNumber();
        if ($order['orders_id'] != "" && !is_null($order['orders_id'])) {
          $riderNumbers = RiderNumber::find($order['orders_id']);
        }

        if ($order['orders'] != "") {
          $riderNumbers->orders = $order['orders'];
          $riderNumbers->orders_date = $order['orders_date'];
          $riderNumbers->comments = $order['comment'];
          $riderNumbers->employee_id = $order['id'];

          $riderNumbers->save();
        }else{
          if ($order['orders_id'] != "" && !is_null($order['orders_id'])) {
            $riderNumbers->delete();
          }
        }
      }

    	return $this->getRidersOrderByDate($request->orders_date);
    }
}
