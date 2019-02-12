@extends('layouts.dashboard')

@section('title', 'User Management')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/datatables/media/css/dataTables.bootstrap.css') }}">
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body">
				<div class="pad-btm form-inline">
					<div class="row">
						<div class="col-sm-6 table-toolbar-left">
							<button class="btn btn-purple" data-toggle = "modal" data-target="#user-modal"><i class="demo-pli-add icon-fw"></i>Add</button>
						</div>
					</div>
				</div>
				<div class="table-responsive">
					<table class="table table-vcenter mar-top" id="users-table">
						<thead>
							<tr>
								{{-- <th class="min-w-td">#</th> --}}
								<th class="min-w-td"></th>
								<th>Full Name</th>
								<th>Email</th>
								<th>User Role</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter = 1; ?>
							@foreach($users as $user)
							<tr>
								{{-- <td class="min-w-td">{{ $counter }}</td> --}}
								<td class="min-w-td"><center><img class="img-circle img-sm" src="{{ $user->avatar }}" /></center></td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ \App\Enums\UserRole::getKey($user->user_role) }}</td>
								<td></td>
								<td></td>
							</tr>
							<?php $counter++; ?>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</div>
@endsection

@section('modal')
<div class="modal fade" id="user-modal" role="dialog" tabindex="-1" aria-labelledby="user-modal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Add User</h4>
			</div>
			{{ Form::open(['files' => true, 'url' => route('add-invoice')]) }}
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label">Full Name</label>
					{{ Form::text('name', NULL, ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					<label class="control-label">Email</label>
					{{ Form::email('email', NULL, ['class' => 'form-control']) }}
				</div>

				<div class="form-group">
					<label class="control-label">Role</label>
					{{ Form::select('user_role', \App\Enums\UserRole::toSelectArray(), NULL, ['class' => 'form-control', 'placeholder' => 'Select a Role for the user']) }}
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
		$('#users-table').dataTable();
	});
</script>
@endsection