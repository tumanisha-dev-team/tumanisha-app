<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Enums\Religion;

use App\Rider;
use App\RiderSchedule;
use App\RiderNumber;

use Intervention\Image\ImageManagerStatic as Image;
use PDF;

class EmployeeController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}
    function riders(){
        $data['riders'] = Rider::all();
    	return view('dashboard.employees.riders')->with($data);
    }

    function newRider(){
    	$data['religions'] = Religion::toSelectArray();
    	return view('dashboard.employees.newrider')->with($data);
    }

    function store(Request $request){
        $rider = new Rider();

        $this->validate($request, [
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'national_id_no'        =>  'required|unique:riders',
            'license_no'            =>  'required|unique:riders',
            'kra_pin'               =>  'required|unique:riders',
            'nhif_no'               =>  'required|unique:riders',
            'date_of_birth'         =>  'required',
            'gender'                =>  'required',
            'nationality'           =>  'required',
            'religion'              =>  'required',
            'primary_phone_number'  =>  'required|unique:riders',
            'email'                 =>  'required|unique:riders',
            'height'                =>  'required',
            'eye_color'             =>  'required',
            'hair_color'            =>  'required',
			'starting_date'			=>	'required'
        ]);

        $rider->first_name = $request->input('first_name');
        $rider->last_name = $request->input('last_name');
        $rider->national_id_no = $request->input('national_id_no');
        $rider->license_no = $request->input('license_no');
        $rider->kra_pin = $request->input('kra_pin');
        $rider->nhif_no = $request->input('nhif_no');
        $rider->date_of_birth = $request->input('date_of_birth');
        $rider->gender = $request->input('gender');
        $rider->nationality = ($request->input('nationality')) ? $request->input('nationality') : 'Kenyan';
        $rider->religion = $request->input('religion');
        $rider->primary_phone_number = $request->input('primary_phone_number');
        $rider->secondary_phone_number = $request->input('secondary_phone_number');
        $rider->email = $request->input('email');
        $rider->height = $request->input('height');
        $rider->eye_color = $request->input('eye_color');
        $rider->hair_color = $request->input('hair_color');
		$rider->starting_date = $request->input('starting_date');

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image'                 =>  'required|mimes:jpeg,jpg,png'
            ]);
            $rider->photo_url = $request->file('image')->store('profiles');
        }


        $rider->save();
        return redirect()->route('riders-list')->with('success', 'Successfully added a rider');

    }

    function editRider($id){
        $data['religions'] = Religion::toSelectArray();
        $data['rider'] = Rider::findOrFail($id);
        return view('dashboard.employees.editrider')->with($data);
    }

    function updateRider(Request $request){
        $rider = Rider::findOrFail($request->id);

        $this->validate($request, [
            'first_name'            =>  'required',
            'last_name'             =>  'required',
            'national_id_no'        =>  'required',
            'license_no'            =>  'required',
            'kra_pin'               =>  'required',
            'nhif_no'               =>  'required',
            'date_of_birth'         =>  'required',
            'gender'                =>  'required',
            'nationality'           =>  'required',
            'religion'              =>  'required',
            'primary_phone_number'  =>  'required',
            'email'                 =>  'required',
            'height'                =>  'required',
            'eye_color'             =>  'required',
            'hair_color'            =>  'required',
			'starting_date'			=>	'required'
        ]);

        $rider->first_name = $request->input('first_name');
        $rider->last_name = $request->input('last_name');
        $rider->national_id_no = $request->input('national_id_no');
        $rider->license_no = $request->input('license_no');
        $rider->kra_pin = $request->input('kra_pin');
        $rider->nhif_no = $request->input('nhif_no');
        $rider->date_of_birth = $request->input('date_of_birth');
        $rider->gender = $request->input('gender');
        $rider->nationality = ($request->input('nationality')) ? $request->input('nationality') : 'Kenyan';
        $rider->religion = $request->input('religion');
        $rider->primary_phone_number = $request->input('primary_phone_number');
        $rider->secondary_phone_number = $request->input('secondary_phone_number');
        $rider->email = $request->input('email');
        $rider->height = $request->input('height');
        $rider->eye_color = $request->input('eye_color');
        $rider->hair_color = $request->input('hair_color');
				$rider->starting_date = new \Carbon\Carbon($request->input('starting_date'));

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image'                 =>  'required|mimes:jpeg,jpg,png'
            ]);
            $rider->photo_url = $request->file('image')->store('profiles');
        }


        $rider->save();
        return redirect()->back()->with('success', 'Successfully updated rider information');
    }

	function details($id){
		$data['rider'] = Rider::find($id);
        $today = \Carbon\Carbon::now();
        $data['current_month_numbers'] = RiderNumber::where('employee_id', $id)->whereBetween('orders_date', [$today->startOfMonth()->format('Y-m-d'), $today->endOfMonth()->format('Y-m-d')])->sum('orders');
		return view('dashboard.employees.details')->with($data);
	}

	function weeklyschedule(){
		$riders = Rider::all();
		$riders = $riders->each(function($model){
			$model->setAppends(['name']);
		});
		$data['riders'] = $riders->pluck('name', 'id');
		return view('dashboard.employees.schedule')->with($data);
	}

    function generateScheduleReport(Request $request){
        $duration = $request->duration;
        $date_format = "Y-m-d";

        $start_date = $end_date = new \Carbon\Carbon();
        switch ($duration) {
            case 'this-week':
                $start_date = \Carbon\Carbon::now()->startOfWeek()->format($date_format);
                $end_date = \Carbon\Carbon::now()->endOfWeek()->format($date_format);
                break;

            case 'last-week':
                $last_week = \Carbon\Carbon::now()->subWeek();

                $start_date = $last_week->startOfWeek()->format($date_format);
                $end_date = $last_week->endOfWeek()->format($date_format);
                break;

            case 'this-month':
                $start_date = (new \Carbon\Carbon('first day of this month'))->format($date_format);
                $end_date = (new \Carbon\Carbon('last day of this month'))->format($date_format);
                break;
            
            default:
                break;
        }

        $schedule = RiderSchedule::whereBetween('from', [$start_date, $end_date])
                                    ->orderBy('from', 'ASC')
                                    ->get();

        $cleanedSchedules = [];

        foreach ($schedule as $s) {
            $period = \Carbon\CarbonPeriod::create($s->from, $s->to);
            foreach ($period as $date) {
                $cleanedSchedules[$date->format('Y-m-d')][] = [
                    'rider' =>  ucwords(strtolower($s->rider->name)),
                    'type'  =>  $s->type
                ];
            }
        }

        $data['dates'] = $cleanedSchedules;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $pdf = PDF::loadView('pdf.schedule', $data);
        return $pdf->stream('schedule.pdf');
    }
}
