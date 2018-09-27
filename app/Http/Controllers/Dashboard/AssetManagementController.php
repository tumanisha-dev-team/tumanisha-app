<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Enums\AssetType;
use App\Enums\ReportStatus;

use App\Asset;
use BenSampo\Enum\Rules\EnumValue;
use App\AssetTrackerReport;

class AssetManagementController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}
    function index(){
    	$data['asset_types'] = AssetType::toSelectArray();
    	$data['assets'] = Asset::all();
    	return view('dashboard.assetmanagement.index')->with($data);
    }

    function store(Request $request){
    	$this->validate($request, [
    		'engine_no'			=>	'required|unique:assets',
    		'chassis_no' 		=>	'required|unique:assets',
    		'registration_no'	=>	'required|unique:assets',
    		'color'				=>	'required',
    		'model'				=>	'required',
    		'asset_type'		=>	['required'],
    		'make'				=>	'required',
    		'engine_body'		=>	'required'
    	]);

    	if($asset = Asset::create($request->all())){
    		$asset->company_id = "TUM-".sprintf("%04d", $asset->id);
    		$asset->save();
	    	return back()->with('success', "Successfully added your asset");
		}
		return back()->with('error', 'There was an error adding the asset');
    }

    function manage(Request $request){
    	$data['asset_types'] = AssetType::toSelectArray();
    	$data['asset'] = Asset::where('company_id', $request->id)->first();
    	$data['report_status'] = ReportStatus::toSelectArray();
    	$data['reports'] = AssetTrackerReport::get();
    	return view('dashboard.assetmanagement.manage')->with($data);
    }

    function update(Request $request){
    	$asset = Asset::findOrFail($request->id);

    	$asset = $asset->update($request->all());
    	
    	return back()->withSuccess('Successfully updated asset details');
    }

    function storeTrackerReport(Request $request){
    	$this->validate($request, [
    		'report_date'		=>	'required',
    		'status'			=>	'required'
    	]);

    	$company_id = $request->id;

    	$asset = Asset::where('company_id', $company_id)->first();

    	$trackerReport = new AssetTrackerReport();

    	$trackerReport->assets_id = $asset->id;
    	$trackerReport->report_date = $request->input('report_date');
    	$trackerReport->status = $request->input('status');
    	$trackerReport->description = $request->input('description');

    	$trackerReport->save();

    	return back()->withSuccess('Successfully added report');
    }
}
