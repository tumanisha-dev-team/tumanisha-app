@extends('layouts.dashboard')

@section('title', 'Riders')

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
			<div class="pad-all">
				<div class="widget-control">
					<div class="btn-group dropdown">
						<a href="#" class="dropdown-toggle btn btn-trans" data-toggle="dropdown" aria-expanded="false"><i class="demo-psi-dot-vertical icon-lg"></i></a>
						<ul class="dropdown-menu dropdown-menu-right" style="">
							<li><a href="{{ route('edit-rider', $rider->id) }}"><i class="icon-lg icon-fw demo-psi-pen-5"></i> Edit</a></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-recycling"></i> Remove</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-mail"></i> Send a Message</a></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-calendar-4"></i> View Details</a></li>
							<li><a href="#"><i class="icon-lg icon-fw demo-pli-lock-user"></i> Lock</a></li>
						</ul>
					</div>
				</div>
				
				<div class = "pad-all">
					<div class = "media pad-ver">
						<div class = "media-left">
							<a href="#" class="box-inline">
								<img alt="Profile Picture" class="img-md img-circle" src="{{ $rider->rider_avatar }}">
							</a>
						</div>
						
						<div class = "media-body pad-top">
							<a class = "box-inline" href="">
								<span class = "text-md text-semibold text-main">{{ $rider->first_name . ' ' . $rider->last_name }}</span>
								<p class="text-sm">Rider</p>
							</a>
							
						</div>
					</div>
				</div>

				<p class="pad-btm bord-bt text-sm">Born on: {{ \Carbon\Carbon::parse($rider->date_of_birth)->format('dS F, Y') }}</p>
				
			</div>
		</div>
	</div>
	@empty
	@endforelse
</div>
@endsection