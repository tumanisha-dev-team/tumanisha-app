@extends('layouts.dashboard')

@section('title', 'User Management');

@section('content')
<div class="row">
	<div class="col-lg-9">
		<div class="panel">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-vcenter mar-top">
						<thead>
							<tr>
								<th class="min-w-td">#</th>
								<th class="min-w-td"></th>
								<th>Full Name</th>
								<th>Email</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php $counter = 1; ?>
							@foreach($users as $user)
							<tr>
								<td class="min-w-td">{{ $counter }}</td>
								<td></td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
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