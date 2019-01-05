<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Rider;
use App\RiderNumber;
use App\RiderSchedule;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

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
              ->orderBy('riders.jumia_no', 'ASC')
    					->get();

    	return $riderNumbers;
    }

    function getMonthOrders($month){
      $orders = RiderNumber::select(\DB::raw('SUM(orders) AS orders'))
                            ->where(\DB::raw('MONTH(orders_date)'), $month)
                            ->groupBy(\DB::raw('MONTH(orders_date)'))
                            ->first();

      if($orders == NULL){
        $orders = [
          'orders'  =>  0
        ];
      }

      return $orders;
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

    function storeRiderSchedule(Request $request){
    	$this->validate($request, [
          'rider_id'  =>  'required',
          'type'      =>  'required',
          'from'      =>  'required',
          'to'        =>  'required'
        ]);

		if ($request->id == "") {
			$schedule = new RiderSchedule();
		}else{
			$schedule = RiderSchedule::find($request->id);
		}

		$schedule->rider_id = $request->rider_id;
		$schedule->type = $request->type;
		$schedule->from = $request->from;
		$schedule->to = $request->to;
		$schedule->notes = $request->notes;

		$schedule->save();

		return $schedule;
    }

    function getMonthlySchedule($month){
      $schedule = RiderSchedule::where(\DB::raw('MONTH(`from`)'), $month)
                                ->orWhere(\DB::raw('MONTH(`to`)'), $month)
                                ->with('rider')
                                ->get();

      return $schedule;
    }

    function getSchedule(Request $request){
      $schedule = RiderSchedule::whereBetween('from', [$request->start, $request->end])
                                ->with('rider')
                                ->get();

      $eventsArray = [];

      foreach($schedule as $s){
        $enddate = new \Carbon\Carbon($s->to);

        $eventsArray[] = [
          'id'        =>  $s->id,
          'title'     =>  $s->rider->name,
          'rider_id'  =>  $s->rider_id,
          'start'     =>  $s->from,
          'end'       =>  $enddate->addDays(1)->format('Y-m-d'),
          'allDay'    =>  true,
          'className' =>  ($s->type == "off") ? "purple" : "danger",
          'backgroundColor' => ($s->type == "off") ? "purple" : "red",
          'type'      =>  $s->type,
          'notes'     =>  $s->notes,
          'dates'     =>  [
            'from'    =>  $s->from,
            'to'      =>  $s->to
          ]
        ];
      }
      return $eventsArray;
    }

	function deleteSchedule($id){
		return RiderSchedule::destroy($id);
	}

  function getLast8Months(Request $request){
    $rider_id = $request->rider_id;
    $today = Carbon::now()->startOfMonth();
    $monthsago = Carbon::now()->subMonths(7)->startOfMonth();

    $period = CarbonPeriod::create($monthsago, '1 month', $today);

    $response = [];
    foreach ($period as $dt) {
      $data = RiderNumber::where('employee_id', $rider_id)
                          ->whereBetween('orders_date', [$dt->format('Y-m-d'), $dt->endOfMonth()->format('Y-m-d')])
                          ->sum('orders');

      $response[] = [
        'month'   =>  $dt->format('F Y'),
        'numbers' =>  (int)$data
      ];
      // echo $dt->endOfMonth(). "<br/>";
    }

    return $response;
  }

  function getMonthNumbers(Request $request){
    $rider_id = $request->rider_id;
    $month = $request->month;
    $year = $request->year;

    $parsedDate = \Carbon\Carbon::parse("$month $year");
    $firstday = $parsedDate->startOfMonth()->format('Y-m-d');
    $lastday = $parsedDate->endOfMonth()->format('Y-m-d');

    $monthData = RiderNumber::where('employee_id', $rider_id)
                              ->whereBetween('orders_date', [$firstday, $lastday])
                              ->get();

    // dd($monthData);

    $response = [];
    if (count($monthData)) {
      $formatMonthData = [];
      foreach ($monthData as $data) {
        $formatMonthData[$data->orders_date] = $data->orders;
      }
      $dates = array_keys($formatMonthData);
      $period = (\Carbon\CarbonPeriod::create($firstday, $lastday))->toArray();

      foreach ($period as $dt) {
        if (in_array($dt->format('Y-m-d'), $dates)) {
          $response[] = [
            'date'   =>  $dt->format('Y-m-d'),
            'number'  =>  (int)$formatMonthData[$dt->format('Y-m-d')]
          ];
        }else{
          $response[] = [
            'date'   =>  $dt->format('Y-m-d'),
            'number'  =>  ""
          ];
        }
      }
    }
    return $response;
  }
}
