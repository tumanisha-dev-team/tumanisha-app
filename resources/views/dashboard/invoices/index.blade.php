@extends('layouts.dashboard')

@section('title', 'Riders')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">Invoice Listing</h3>
	</div>
	<div class="panel-body">
		<div class="pad-btm form-inline">
			<div class="row">
				<div class="col-sm-6 table-toolbar-left">
					<button class="btn btn-purple" data-toggle = "modal" data-target="#add-invoice-modal">
						<i class="demo-pli-add"></i> Add
					</button>
				</div>

				<div class="col-sm-6 table-toolbar-right">
					<div class="form-group">
						<input class="form-control" type="text" placeholder="search" />
					</div>
					<div class="btn-group">
						
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Invoice No.</th>
						<th>Invoice Date</th>
						<th>From</th>
						<th>To</th>
						<th class="text-right">Amount (KSH.)</th>
						<th class="text-right">Tax (KSH.)</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($invoices as $invoice)
					<tr>
						<td>{{ $invoice->invoice_no }}</td>
						<td><i class="demo-pli-clock"></i>&nbsp;{{ Carbon\Carbon::parse($invoice->invoice_date)->format('d M, Y') }}</td>
						<td>{{ Carbon\Carbon::parse($invoice->from)->format('d M, Y') }}</td>
						<td>{{ Carbon\Carbon::parse($invoice->to)->format('d M, Y') }}</td>
						<td class="text-right">KSH. {{ number_format($invoice->amount) }}</td>
						<td class="text-right">KSH. {{ number_format($invoice->tax) }}</td>
						<td>
							@if($invoice->status)
							<div class="label label-table label-success">Paid</div>
							@else
							<div class="label label-table label-danger">Not Paid</div>
							@endif
						</td>
						<td>
							<div class="btn-group btn-group-sm">
								<div class="dropdown">
									<button class="btn btn-sm btn-mint btn-active-purple dropdown-toggle" data-toggle="dropdown" type="button">Action <i class="dropdown-caret"></i></button>
									<ul class="dropdown-menu">
										<li><a href="{{ route('edit-invoice', ['id' => $invoice->id]) }}"><i class="demo-psi-pen-5"></i>&nbsp;Edit Invoice</a></li>
										<li><a href="{{ route('download-invoice', ['id' => $invoice->id]) }}"><i class="demo-pli-download-from-cloud"></i>&nbsp;Download Invoice</a></li>
									</ul>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="add-invoice-modal" role="dialog" tabindex="-1" aria-labelledby="add-invoice-modal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Adding Invoice</h4>
			</div>
			{{ Form::open(['files' => true, 'url' => route('add-invoice')]) }}
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label">Invoice No.</label>
					{{ Form::text('invoice_no', null, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('invoice_date', 'Invoice Date') }}
					{{ Form::text('invoice_date', null, ['class' => 'form-control', 'data-date-end-date' => '0d']) }}
				</div>

				<div class="form-group">
					{{ Form::label('invoice_period', 'Invoice Period') }}
					<div id="demo-dp-range">
						<div class="input-daterange input-group" id="datepicker">
							{{ Form::text('from', null, ['class' => 'form-control', 'required']) }}
							<span class="input-group-addon">to</span>
							{{ Form::text('to', null, ['class' => 'form-control', 'required']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('amount', 'Amount') }}
					{{ Form::number('amount', null, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('tax', 'Tax') }}
					{{ Form::number('tax', null, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('status', 'Invoice Status') }}
					{{ Form::select('status', [0 => 'Not Paid', 1 => 'Paid'], null, ['class' => 'form-control', 'placeholder' => 'Select the currect invoice status']) }}
				</div>

				<div class="form-group">
					{{ Form::label('file', 'Invoice File') }}
					{{ Form::file('file', null, ['class' => 'form-control', 'required']) }}
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				<button class="btn btn-primary">Save changes</button>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection

@section('js')
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$('input[name="invoice_date"]').datepicker({
		clearBtn: true,
		disableTouchKeyboard: true,
		endDate: new Date(),
		autoclose: true
	});

	$('#demo-dp-range .input-daterange').datepicker({
		format: 'MM dd, yyyy',
		todayBtn: 'linked',
		autoclose: true,
		todayHighlight: true
	});
</script>
@endsection