@extends('layouts.dashboard')

@section('title', 'Edit Invoice')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="col-md-8">
	<div class="panel">
		<div class="panel-heading">
			<h3 class="panel-title">Editing Invoice</h3>
		</div>
		<div class="panel-body">
			{{ Form::open(['files'=>true,'url'=>route('invoice-send-update', ['id' => $invoice->id])]) }}
				<div class="form-group">
					<label class="control-label">Invoice No.</label>
					{{ Form::text('invoice_no', $invoice->invoice_no, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('invoice_date', 'Invoice Date') }}
					{{ Form::text('invoice_date', Carbon\Carbon::parse($invoice->invoice_date)->format('F d, Y'), ['class' => 'form-control', 'data-date-end-date' => '0d']) }}
				</div>

				<div class="form-group">
					{{ Form::label('invoice_period', 'Invoice Period') }}
					<div id="demo-dp-range">
						<div class="input-daterange input-group" id="datepicker">
							{{ Form::text('from', Carbon\Carbon::parse($invoice->from)->format('F d, Y'), ['class' => 'form-control', 'required']) }}
							<span class="input-group-addon">to</span>
							{{ Form::text('to', Carbon\Carbon::parse($invoice->to)->format('F d, Y'), ['class' => 'form-control', 'required']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('amount', 'Amount') }}
					{{ Form::number('amount', $invoice->amount, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('tax', 'Tax') }}
					{{ Form::number('tax', $invoice->tax, ['class' => 'form-control', 'required']) }}
				</div>

				<div class="form-group">
					{{ Form::label('status', 'Invoice Status') }}
					{{ Form::select('status', [0 => 'Not Paid', 1 => 'Paid'], $invoice->status, ['class' => 'form-control', 'placeholder' => 'Select the currect invoice status']) }}
				</div>

				<div class="form-group">
					{{ Form::label('file', 'Invoice File') }}
					{{ Form::file('file', null, ['class' => 'form-control', 'required']) }}
				</div>

				<button class="btn btn-success">Update Data</button>
			{{ Form::close() }}
		</div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	invoice_date = $('input[name="invoice_date"]').datepicker({
		format: 'MM dd, yyyy',
		clearBtn: true,
		disableTouchKeyboard: true,
		endDate: new Date(),
		autoclose: true,
	});

	range = $('#demo-dp-range .input-daterange').datepicker({
		format: 'MM dd, yyyy',
		todayBtn: 'linked',
		autoclose: true,
	});
</script>
@endsection