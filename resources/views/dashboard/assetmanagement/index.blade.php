@extends('layouts.dashboard')

@section('title', 'Asset Management')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="panel">
	<div class="panel-heading">
		<div class="panel-control">
			<button class="btn btn-default" data-target = "#add-assets-modal" data-toggle="modal">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Add Asset
			</button>
			
		</div>
		<h2 class="panel-title">Asset List</h2>
	</div>
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<th>Company ID</th>
					<th>Registration No.</th>
					<th>Log Book No.</th>
					<th>Model</th>
					<th>Color</th>
					<th>Insurance Status</th>
					<th>Tracker Status</th>
					<th>Actions</th>
				</thead>
				<tbody>
					@foreach($assets as $asset)
					<tr>
						<td>{{ $asset->company_id }}</td>
						<td>{{ $asset->registration_no }}</td>
						<td>{{ $asset->log_book_no }}</td>
						<td>{{ $asset->model }}</td>
						<td>{{ $asset->color }}</td>
						<td></td>
						<td></td>
						<td>
							<div class="btn-group">
								<div class="dropdown">
									<button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">Actions <i class="dropdown-caret"></i></button>
									<ul class="dropdown-menu dropdown-menu-right" style="">
										<li><a href="{{ route('manageAsset', $asset->company_id) }}">Manage Asset</a></li>
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
<div class="modal fade" id="add-assets-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Add Asset</h4>
			</div>
			{{ Form::open(['route' => 'addAsset']) }}
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							{{ Form::label('asset_type', 'Asset Type', ['class' => 'control-label']) }}
							{{ Form::select('asset_type', $asset_types, NULL, ['class' => 'form-control']) }}
						</div>
						<div class="form-group">
							{{ Form::label('registration_no', 'Registration Number', ['class' => 'control-label']) }}
							{{ Form::text('registration_no', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('engine_body', 'Engine Body', ['class' => 'control-label']) }}
							{{ Form::text('engine_body', NULL, ['class' => 'form-control']) }}
						</div>
						<div class="form-group">
							{{ Form::label('dealer', 'Dealer', ['class' => 'control-label']) }}
							{{ Form::text('dealer', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('make', 'Make', ['class' => 'control-label']) }}
							{{ Form::text('make', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('chassis_no', 'Chassis Number', ['class' => 'control-label']) }}
							{{ Form::text('chassis_no', NULL, ['class' => 'form-control']) }}
						</div>
					</div>

					<div class="col-sm-6">
						<div class="form-group">
							{{ Form::label('log_book_no', 'Log Book Number', ['class' => 'control-label']) }}
							{{ Form::text('log_book_no', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('color', 'Color', ['class' => 'control-label']) }}
							{{ Form::text('color', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('engine_no', 'Engine No', ['class' => 'control-label']) }}
							{{ Form::text('engine_no', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('invoice_no', 'Invoice No', ['class' => 'control-label']) }}
							{{ Form::text('invoice_no', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('model', 'Model', ['class' => 'control-label']) }}
							{{ Form::text('model', NULL, ['class' => 'form-control']) }}
						</div>

						<div class="form-group">
							{{ Form::label('date_purchased', 'Purchase Date', ['class' => 'control-label']) }}
							{{ Form::date('date_purchased', NULL, ['class' => 'form-control']) }}
						</div>
					</div>
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
<script type="text/javascript" src="{{ asset('dashboard/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('table').dataTable();
	});
</script>
@endsection