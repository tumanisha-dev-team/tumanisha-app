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
	<div class="col-sm-4 col-md-3">
	</div>
</div>
@endsection