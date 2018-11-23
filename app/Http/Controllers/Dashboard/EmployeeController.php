<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Enums\Religion;

use App\Rider;

use Intervention\Image\ImageManagerStatic as Image;

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

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image'                 =>  'required|mimes:jpeg,jpg,png'
            ]);
            $rider->photo_url = $request->file('image')->store('profiles');
        }
        

        $rider->save();
        return redirect()->route('riders-list')->with('success', 'Successfully added a rider');

    }
}
