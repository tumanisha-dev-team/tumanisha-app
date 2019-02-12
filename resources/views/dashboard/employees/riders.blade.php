@extends('layouts.dashboard')

@section('title', 'Riders')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="row pad-btm">
	<div class="col-sm-6 toolbar-left">
		<a id="demo-btn-addrow" class="btn btn-purple" href="{{ route('new-rider') }}">Add New</a>
		<button class="btn btn-default"><i class="demo-pli-printer"></i></button>
	</div>

	<div class="col-sm-6 toolbar-right text-right">
		Sort by :
		<div class="select">
			<select id="demo-ease">
				<option value="employment-date" selected="">Employment Date</option>
				<option value="alpabetically">Alpabetically</option>
			</select>
		</div>

		<a class="btn btn-default">Filter</a>
	</div>
</div>

<div class="row">
	@forelse($riders as $rider)
	<div class="col-sm-4 col-md-3">
		<div class="panel pos-rel">
			<div class="pad-all text-center">
				<div class="widget-control">
					@if(count($rider->deactivated) > 0)
					<a href="#" class="add-tooltip btn btn-trans" data-original-title="Deactivated"><span class="text-danger"><i class="fa fa-circle icon-lg"></i></span></a>
					@endif
					<div class="btn-group dropdown">
						<a href="#" class="dropdown-toggle btn btn-trans" data-toggle="dropdown" aria-expanded="false"><i class="demo-psi-dot-vertical icon-lg"></i></a>
						<ul class="dropdown-menu dropdown-menu-right" style="">
							<li><a href="{{ route('edit-rider', $rider->id) }}"><i class="icon-lg icon-fw demo-psi-pen-5"></i> Edit</a></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-recycling"></i> Remove</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-mail"></i> Send a Message</a></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-calendar-4"></i> View Details</a></li>
							@if(count($rider->deactivated) == 0)
							<li><a href="#" class="deactivate-rider" data-id = "{{ $rider->id }}" data-name = "{{ $rider->name }}" data-target = "#deactivate-rider-modal" data-toggle="modal" data-avatar="{{ $rider->rider_avatar }}"><i class="icon-lg icon-fw demo-pli-lock-user"></i> Deactivate</a></li>
							@endif
						</ul>
					</div>
				</div>
				<a href="#">
            <img alt="Profile Picture" class="img-lg img-circle mar-ver" src="{{ $rider->rider_avatar }}">
            <p class="text-lg text-semibold mar-no text-main">{{ $rider->first_name . ' ' . $rider->last_name }}</p>
            <p class="text-sm">Rider</p>
            <p class="text-sm">Date started: {{ \Carbon\Carbon::parse($rider->date_started)->format('dS F Y') }}</p>
        </a>
				<div class="text-center pad-to">
						<div class="btn-group">
								<a href="{{ route('rider-details', $rider->id) }}" class="btn btn-sm btn-default"><i class="demo-pli-receipt-4 icon-lg icon-fw"></i> Details</a>
								<a href="#" class="btn btn-sm btn-default"><i class="demo-pli-mail icon-lg icon-fw"></i> Email</a>
					      <a href="{{ route('edit-rider', $rider->id) }}" class="btn btn-sm btn-default"><i class="demo-pli-pen-5 icon-lg icon-fw"></i> Edit</a>
						</div>
				</div>
			</div>
		</div>
	</div>
	@empty
	@endforelse
</div>
@endsection

@section('modal')
<div class="modal fade" id="deactivate-rider-modal" role="dialog" tabindex="-1" aria-labelledby="demo-default-modal" aria-hidden="true">
	<div class="modal-dialog">
		{!! Form::open(['url' => route('deactivate-rider')]) !!}
		<div class="modal-content">

			<!--Modal header-->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Deactivating Account</h4>
			</div>

			<!--Modal body-->
			<div class="modal-body">
				<center>
					<img id="rider-image" alt="Profile Picture" class="img-lg img-circle mar-ver" src="{{ $rider->rider_avatar }}">
					<h3>Deactivating <span id="rider_name">Rider Name</span></h3>
				</center>

				{{ Form::hidden('rider_id', 0, ['id' => 'rider_id']) }}

				<div class="form-group">
					{!! Form::label('date', 'Deactivation Period') !!}
					<div id="demo-dp-range">
						<div class="input-daterange input-group" id="datepicker">
							{{ Form::text('from', null, ['class' => 'form-control', 'required']) }}
							<span class="input-group-addon">to</span>
							{{ Form::text('to', null, ['class' => 'form-control']) }}
						</div>
					</div>
				</div>

				<div class="form-group">
					{{ Form::label('reason', 'Comment') }}
					{{ Form::textarea('reason', NULL, ['class' => 'form-control', 'rows' => 8]) }}
				</div>
			</div>

			<!--Modal footer-->
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				<button class="btn btn-primary">Deactivate Rider<button>
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('js')
<script src="{{ asset('dashboard/plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	
	$(document).ready(function(){
		datePicker = $('#demo-dp-range .input-daterange').datepicker({
			format: 'MM dd, yyyy',
			todayBtn: 'linked',
			autoclose: true,
			todayHighlight: true
		});
	});

	$("#demo-dp-range .input-daterange").datepicker().on('show.bs.modal', function(event) {
		// prevent datepicker from firing bootstrap modal "show.bs.modal"
		event.stopPropagation(); 
	});

	$("#demo-dp-range .input-daterange").datepicker().on('hide.bs.modal', function(event) {
		// prevent datepicker from firing bootstrap modal "hide.bs.modal"
		event.stopPropagation(); 
	});

	$('#deactivate-rider-modal').on('show.bs.modal', function(event){
		var button = $(event.relatedTarget);

		var modal = $(this);

		console.log(modal);

		modal.find('#rider_name').text(button.data('name'));
		modal.find('#rider-image').attr('src', button.data('avatar'));
		modal.find('#rider_id').val(button.data('id'));
	});

	$('#deactivate-rider-modal').on('hide.bs.modal', function(event){
		var modal = $(this);

		modal.find('#rider_name').text("");
		modal.find('#rider_id').val(0);
	});
</script>
@endsection
