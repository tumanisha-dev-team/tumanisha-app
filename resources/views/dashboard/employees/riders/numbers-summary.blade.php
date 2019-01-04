@extends('layouts.dashboard')

@section('content')
<div class="panel">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12">
				<table class="table table-bordered table-striped">
					<thead>
						<th>Rider</th>
						@foreach($period as $date)
						<th>{{ $date->format('d') }}</th>
						@endforeach
					</thead>
					<tbody>
						@if($this_month_numbers)
							@foreach($this_month_numbers as $number)
								<tr>
									<td>{{ $number->rider->name }}</td>
									@foreach($period as $date)

									@endforeach
								</tr>
							@endforeach
						@else
							<tr><td colspan="{{ count($period) }}"><center>There is no data ti display</center></td></tr>
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection