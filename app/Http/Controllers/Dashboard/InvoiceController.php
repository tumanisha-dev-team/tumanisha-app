<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Invoice;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    function index(){
    	$data['invoices'] = Invoice::all();
    	return view('dashboard.invoices.index')->with($data);
    }

    function store(Request $request){

    	$this->validate($request, [
    		'invoice_no'		=>	'required|unique:invoices',
    		'invoice_date'		=>	'required',
    		'to'				=>	'required',
    		'from'				=>	'required',
    		'amount'			=>	'required',
    		'tax'				=>	'required',
    		'file'				=>	'mimes:jpeg,jpg,png,xls,xlsx,pdf'
    	]);

    	$path = $request->file('file')->store('invoices');

    	$invoice = new Invoice();

    	$invoice->invoice_no = $request->input('invoice_no');
    	$invoice->invoice_date = $request->input('invoice_date');
    	$invoice->to = $request->input('to');
    	$invoice->from = $request->input('from');
    	$invoice->amount = $request->input('amount');
    	$invoice->tax = $request->input('tax');
    	$invoice->status = ($request->input('status')) ? $request->input('status') : false;
    	$invoice->uploaded_by = \Auth::user()->id;
    	$invoice->invoice_file_url = $path;

    	$invoice->save();

    	return back()->with('success', 'Successfully saved invoice :)');
    }

    function downloadInvoice(Request $request){
        $invoice = Invoice::find($request->id);

        return \Storage::download($invoice->invoice_file_url);
    }

    function editInvoice(Request $request){
        $data['invoice'] = Invoice::find($request->id);
        return view('dashboard.invoices.edit')->with($data);
    }

    function update(Request $request){
        $invoice = Invoice::find($request->id);

        $this->validate($request, [
            'invoice_no'        =>  'required',
            'invoice_date'      =>  'required',
            'to'                =>  'required',
            'from'              =>  'required',
            'amount'            =>  'required',
            'tax'               =>  'required'
        ]);

        $file_path = $invoice->invoice_file_url;

        if ($request->hasFile('file')) {
           $this->validate($request, [
                'file'              =>  'mimes:jpeg,jpg,png,xls,xlsx,pdf'
           ]);

           \Storage::delete($invoice->invoice_file_url);
           $file_path = $request->file('file')->store('invoices');
        }

        $invoice->invoice_no = $request->input('invoice_no');
        $invoice->invoice_date = $request->input('invoice_date');
        $invoice->to = $request->input('to');
        $invoice->from = $request->input('from');
        $invoice->amount = $request->input('amount');
        $invoice->tax = $request->input('tax');
        $invoice->status = ($request->input('status')) ? $request->input('status') : false;
        // $invoice->uploaded_by = \Auth::user()->id;
        $invoice->invoice_file_url = $file_path;

        // echo "<pre>";print_r($invoice);die;

        $invoice->save();

        return back()->with('success', 'Successfully saved invoice :)');
    }
}
