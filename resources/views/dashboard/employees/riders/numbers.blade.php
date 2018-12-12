@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="panel">
	<div class="panel-heading">
		<h3 class="panel-title">Rider Numbers</h3>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-4">
				<div id="date-picker" data-date = '{{ new \Carbon\Carbon() }}'></div>
			</div>
			<div class="col-md-8">
				<div id="order_list" style="min-height: 200px;"></div>
				<button class="btn btn-success pull-right" id="save-orders">Save Data</button>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		var today = '{{ new \Carbon\Carbon() }}';
		$('#date-picker').datepicker({
			calendarWeeks: true,
			endDate: today,
			todayBtn: "linked",
			todayHighlight: true,
			format: 'yyyy-mm-dd'
		});

		$('#date-picker').on('changeDate', function() {
			$date = $('#date-picker').datepicker('getFormattedDate');
			getRiderNumbers($date);
		});

		$('#save-orders').on('click', function(){
			data = $('#orders-form').serializeArray();

			$.ajax({
				url: '/api/riders/orders/add',
				method: 'POST',
				data: data,
				beforeSend: function(){
					console.log('Posting data...');
				},
				succes: function(res){
					console.log(res);
				}
			});
		});

		getRiderNumbers($('#date-picker').datepicker('getFormattedDate'));
	});

	function getRiderNumbers($date){
		$.ajax({
			url: '/api/riders/orders/' + $date,
			beforeSend: function(){
				console.log('Loading data for: ' + $date);
				$('#order_list').html('<p>Pulling Data</p>');
				$('#save-orders').hide();
			},
			success: function(res){
				console.log(res);
				$('#order_list').html(generateTable(res, $date));
				$('#save-orders').show();
			}
		});
	}

	function generateTable(riders, date){
		$table = '<form id="orders-form"><input type ="hidden" name="orders_date" value = "'+date+'" /><table class = "table table-bordered table-striped">';
		$table += "<tr><th>Rider</th><th>Orders</th><th>Comment</th></tr>";
		$.each(riders, function(key, rider){
			orders = (rider.orders == null) ? "" : rider.orders;
			if (rider.comments == "null" || rider.comments == null) {
				rider.comments = "";
			}
			$table += "<tr><input type='hidden' name='id[]' value='"+rider.id+"' /><th>"+rider.first_name + " " + rider.last_name +"</th><td><input type = 'number' class = 'form-control' name='orders[]' value='"+orders+"'/></td><td><textarea name = 'comments[]' class = 'form-control' rows='1'>"+rider.comments+"</textarea></td></tr>";
		});
		$table += "</table></form>";

		return $table;
	}
</script>
@endsection