@extends('layouts.dashboard')

@section('title', "Manage Asset: $asset->registration_no")

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="panel">
			<div class="panel-heading">
				<div class="panel-control">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#asset-information-tab" data-toggle="tab">Asset Information</a></li>
						<li><a href="#tracker-information-tab" data-toggle="tab">Tracker Information</a></li>
						<li><a href="#insurance-information-tab" data-toggle="tab">Insurance Information</a></li>
					</ul>
				</div>
				<h3 class="panel-title">Asset Management</h3>
			</div>

			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade in active" id="asset-information-tab">
						<div class="row">
							<div class="col-md-12">
								{{ Form::open(['route' => ['editAsset', $asset->company_id], 'method' => 'PUT']) }}
								{{ Form::hidden('id', $asset->id) }}
								<div class="form-group">
									{{ Form::label('company_id', 'Generated Company ID') }}
									{{ Form::text('company_id', $asset->company_id, ['class' => 'form-control', 'disabled' => 'disabled']) }}
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('asset_type', 'Asset Type') }}
											{{ Form::select('asset_type', $asset_types, $asset->asset_type, ['class' => 'form-control']) }}
										</div>
										<div class="form-group">
											{{ Form::label('registration_no', 'Registration Number') }}
											{{ Form::text('registration_no', $asset->registration_no, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('engine_body', 'Engine Body', ['class' => 'control-label']) }}
											{{ Form::text('engine_body', $asset->engine_body, ['class' => 'form-control']) }}
										</div>
										<div class="form-group">
											{{ Form::label('dealer', 'Dealer', ['class' => 'control-label']) }}
											{{ Form::text('dealer', $asset->dealer, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('make', 'Make', ['class' => 'control-label']) }}
											{{ Form::text('make', $asset->make, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('chassis_no', 'Chassis Number', ['class' => 'control-label']) }}
											{{ Form::text('chassis_no', $asset->chassis_no, ['class' => 'form-control']) }}
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											{{ Form::label('log_book_no', 'Log Book Number') }}
											{{ Form::text('log_book_no', $asset->log_book_no, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('color', 'Color', ['class' => 'control-label']) }}
											{{ Form::text('color', $asset->color, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('engine_no', 'Engine No', ['class' => 'control-label']) }}
											{{ Form::text('engine_no', $asset->engine_no, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('invoice_no', 'Invoice No', ['class' => 'control-label']) }}
											{{ Form::text('invoice_no', $asset->invoice_no, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('model', 'Model', ['class' => 'control-label']) }}
											{{ Form::text('model', $asset->model, ['class' => 'form-control']) }}
										</div>

										<div class="form-group">
											{{ Form::label('date_purchased', 'Purchase Date', ['class' => 'control-label']) }}
											{{ Form::date('date_purchased', $asset->date_purchased, ['class' => 'form-control']) }}
										</div>
									</div>
								</div>
								<button class="btn btn-primary">Edit Asset</button>
								{{ Form::close() }}
							</div>
						</div>
						
					</div>

					<div class="tab-pane fade" id="tracker-information-tab">
						<div class="row mar-btm">
							<div class="col-md-12">
								<div class="pull-right">
									<a class="btn btn-sm btn-default btn-labeled" data-toggle="modal" data-target = "#add-report-modal">
										<i class="btn-label fa fa-plus"></i> Add Report
									</a>

									<a class="btn btn-sm btn-success btn-labeled">
										<i class="btn-label fa fa-download"></i> Export Reports
									</a>
								</div>
							</div>
							
						</div>
						
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th>#</th>
									<th>Report Date</th>
									<th>Status</th>
									<th>Comments</th>
									<th>Time Reported</th>
								</thead>
								<tbody>
									<?php $counter = 1; ?>
									@foreach($reports as $report)
									<tr>
										<td><?= @$counter; ?></td>
										<td>{{ $report->report_date }}</td>
										<td>{{ $report->status }}</td>
										<td>{{ $report->description }}</td>
										<td>{{ $report->created_at }}</td>
									</tr>
									<?php $counter++; ?>
									@endforeach
								</tbody>
							</table>
						</div>
						
					</div>

					<div class="tab-pane fade" id="insurance-information-tab">
						<div class="row mar-btm">
							<div class="col-md-12">
								<div class="pull-right">
									<a class="btn btn-sm btn-default btn-labeled" data-toggle="modal" data-target = "#add-insurance-modal">
										<i class="btn-label fa fa-plus"></i> Add Insurance
									</a>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<thead>
									<th>Insurer</th>
									<th>Duration</th>
									<th>Contact Person</th>
									<th>Comment</th>
								</thead>
								<tbody>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-md-4">
		<div class="panel">
			<div class="panel-body">
				<center>
					<h1><i class="fa fa-motorcycle fa-2x"></i></h1>
					<h2>{{ $asset->registration_no }}</h2>
					<h4>Overview</h4>
				</center>

				<table class="table">
					<tr>
						<th>Added On:</th>
						<th>{{ \Carbon\Carbon::parse($asset->created_at)->format('M d, Y h:i a') }}</th>
					</tr>
					<tr>
						<th>Last Updated:</th>
						<th>{{ \Carbon\Carbon::parse($asset->updated_at)->format('M d, Y h:i a') }}</th>
					</tr>
					<tr>
						<th>Insurance Status:</th>
						<th></th>
					</tr>

					<tr>
						<th>Tracker Status:</th>
						<th></th>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection

@section('modal')

<div class="modal fade" id="add-report-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Add Report</h4>
			</div>
			{{ Form::open(['route' => ['addTrackerReport', $asset->company_id]]) }}
			<div class="modal-body">
				<div class="form-group">
					{{ Form::label('report_date', 'Report Date', ['class' => 'control-label']) }}
					{{ Form::date('report_date', date('d/m/Y'), ['class' => 'form-control']) }}
				</div>
				<div class="form-group">
					{{ Form::label('status', 'Tracker Status', ['class' => 'control-label']) }}
					{{ Form::select('status', $report_status,  NULL, ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					{{ Form::label('description', 'Comments', ['class' => 'control-label']) }}
					{{ Form::textarea('description', NULL, ['class' => 'form-control', 'rows' => 8]) }}
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


<div class="modal fade" id="add-insurance-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Add Insurance</h4>
			</div>
			{{ Form::open(['route' => ['addTrackerReport', $asset->company_id]]) }}
			<div class="modal-body">
				<fieldset>
					<legend>Insurer Details</legend>
					<div class="form-group">
						{{ Form::label('insurer_name', 'Insurer Name', ['class' => 'control-label']) }}
						{{ Form::text('insurer_name', NULL, ['class' => 'form-control']) }}
					</div>

					<div class="form-group">
						{{ Form::label('insurer_website', 'Insurer Website', ['class' => 'control-label']) }}
						{{ Form::text('insurer_website', NULL, ['class' => 'form-control']) }}
					</div>

					<div class="form-group">
						{{ Form::label('insurer_phone', 'Insurer Phone Number', ['class' => 'control-label']) }}
						{{ Form::text('insurer_phone', NULL, ['class' => 'form-control']) }}
					</div>
				</fieldset>
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
<script type="text/javascript" src="{{ asset('dashboard/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('table').DataTable();
	});
</script>
@endsection