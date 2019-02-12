@extends('layouts.dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="panel">
	<div class="panel-body">
		<div class="fixed-fluid">
			<div class = "fixed-sm-300 pull-sm-left fixed-right-border">
				<div class="pad-btm bord-btm">
					<a href="#" class="btn btn-block btn-success">Generate Monthly Report</a>
				</div>
				<p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Calendar</p>
				<div id="date-picker" data-date = '{{ new \Carbon\Carbon() }}'></div>
				<div class="list-group bg-trans pad-ver bord-ver">
					<p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Statistics</p>
					<!-- Menu list item -->
					<a href="#" class="list-group-item list-item-sm">
						Current Month: ({{ \Carbon\Carbon::now()->format('F') }}) <span id="current-month-orders" class="badge badge-info badge-icon badge-fw pull-right">0</span>
					</a>

					<a href="#" class="list-group-item list-item-sm">
						Previous Month: ({{ \Carbon\Carbon::now()->subMonth()->format('F') }}) <span id="previous-month-orders" class="badge badge-info badge-icon badge-fw pull-right">0</span>
					</a>

					<a href="#" class="list-group-item list-item-sm">
						Lifetime: <span id="lifetime-orders" class="badge badge-info badge-icon badge-fw pull-right">0</span>
					</a>
				</div>

				<div class="pad-top pad-btm bord-btm">
					<a class="btn btn-md btn-success btn-block" href="{{ route('rider-numbers-summary') }}">View Rider Summary</a>
				</div>
			</div>
			<div class = 'fluid' id="order_container">
				<div class = 'row'>
					<div class="col-sm-7 toolbar-left">
						<h4 class="text-main">Total Orders: <span class="badge badge-warning"><span id="total-orders"></span></span></h4>
					</div>
					<div class="col-sm-5 toolbar-right">
						<b><span class="text-main" id="date-show">{{ \Carbon\Carbon::parse()->format('d F, Y') }}</span></b>
						<div class="btn-group btn-group">
							<button id="date-before" class="btn btn-default" type="button"><i class="demo-psi-arrow-left"></i></button>
							<button id="date-after" class="btn btn-default" type="button" disabled = "true"><i class="demo-psi-arrow-right"></i></button>
						</div>
					</div>
				</div>
				<div id="order_list" style="min-height: 200px;"></div>
				<button class="btn btn-success pull-right" id="save-orders">Save Data</button>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-md-4">
				<div id="date-picker" data-date = '{{ new \Carbon\Carbon() }}'></div>
			</div>
			<div class="col-md-8">
				<div id="order_list" style="min-height: 200px;"></div>
				<button class="btn btn-success pull-right" id="save-orders">Save Data</button>
			</div>
		</div> -->
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/momentjs/moment.min.js') }}">

</script>
<script type="text/javascript">
	$(document).ready(function(){
		var today = '{{ new \Carbon\Carbon() }}';
		getCurrentMonthOrders();
		getLastMonthOrders();
		getLifeTimeOrders();
		var datepicker = $('#date-picker').datepicker({
			calendarWeeks: true,
			endDate: today,
			todayBtn: "linked",
			todayHighlight: true,
			format: 'yyyy-mm-dd'
		});

		$('#order_list').on('keyup', '.orders', function(){
			calculateTotalOrders();
		});

		$('#date-before').click(function(){
			var currentDate = moment(datepicker.datepicker('getDate'));
			manageBeforeAfterButtons(currentDate);
			dateBefore = currentDate.subtract(1, 'days').toDate();
			datepicker.datepicker('setDate', dateBefore);
		});

		$('#date-after').click(function(){
			var currentDate = moment(datepicker.datepicker('getDate'));
			difference = manageBeforeAfterButtons(currentDate);
			if(difference < 0){
				dateAfter = currentDate.add(1, 'days').toDate();
				datepicker.datepicker('setDate', dateAfter);

			}else{
				alert("The date today is the most");
			}
		});

		function manageBeforeAfterButtons(currentDate){
			difference = currentDate.diff(moment(today), 'days');
			if (difference == -1) {
				$('#date-after').prop('disabled', true);
			}else{
				$('#date-after').prop('disabled', false);
			}

			return difference;
		}

		function getCurrentMonthOrders(){
			month = moment().format('M');
			$.get('/api/riders/orders/total/' + month + '/month', function(res){
				$('#current-month-orders').text(res.orders);
			});
		}

		function getLastMonthOrders(){
			month = moment().subtract(1, 'month').format('M');

			$.get('/api/riders/orders/total/' + month + '/month', function(res){
				$('#previous-month-orders').text(res.orders);
			});
		}

		function getLifeTimeOrders(){
			$.get('/api/riders/orders/lifetime/aggregated', function(res){
				$('#lifetime-orders').text(res.orders);
			});
		}

		$('#date-picker').on('changeDate', function() {
			$date = $('#date-picker').datepicker('getFormattedDate');
			$('#date-show').text(moment($date).format('DD MMMM, YYYY'));
			getRiderNumbers($date);
		});

		$('#save-orders').on('click', function(){
			data = $('#orders-form').serializeArray();
			$date = $('#date-picker').datepicker('getFormattedDate');

			$.ajax({
				url: '/api/riders/orders/add',
				method: 'POST',
				data: data,
				beforeSend: function(){
					$('#order_container').block(blockObj);
				},
				success: function(res){
					$('#order_list').html(generateTable(res, $date));
					toastr.success('Orders successfully saved', 'Success');
					$('#order_container').unblock();
				}
			});
		});

		getRiderNumbers($('#date-picker').datepicker('getFormattedDate'));
	});

	function calculateTotalOrders(){
		var ordersText = $('.orders');
		var totalOrders = 0;
		$.each(ordersText, function(key, order){
			val = $(order).val();
			val = (isNaN(val) || val == "") ? 0 : val;
			totalOrders += parseInt(val);
		});
		$('#total-orders').text(totalOrders);
	}

	function getRiderNumbers($date){
		$.ajax({
			url: '/api/riders/orders/' + $date,
			beforeSend: function(){
				// $('#order_list').html('<div class="sk-double-bounce"><div class="sk-child sk-double-bounce1"></div><div class="sk-child sk-double-bounce2"></div></div><p>Please wait while we load this page</p>');
				$('#order_container').block(blockObj);
				$('#save-orders').hide();
			},
			success: function(res){
				$('#order_container').unblock();
				$('#order_list').html(generateTable(res, $date));
				$('#save-orders').show();
				calculateTotalOrders();
			}
		});
	}

	function generateTable(riders, date){
		$table = '<form id="orders-form"><input type ="hidden" name="orders_date" value = "'+date+'" /><table class = "table table-vcenter">';
		$table += "<tr><th style='width: 70px;'></th><th>Rider</th><th style='width:10%'>Orders</th><th>Comment</th></tr>";
		$.each(riders, function(key, rider){
			orders = (rider.orders == null) ? "" : rider.orders;
			if (rider.comments == "null" || rider.comments == null) {
				rider.comments = "";
			}

			if(rider.orders_id == null){
				rider.orders_id = "";
			}

			var src = "/employees/rider/profile_photo/"+rider.id;
			if (rider.photo_url == null) {
				src = "{{ asset('/dashboard/img/profile-photos/2.png') }}"
			}

			$table += "<tr><input type='hidden' name='id[]' value='"+rider.id+"' /><input type='hidden' name='orders_id[]' value='"+rider.orders_id+"' /><td><img class = 'img-sm img-circle img-responsive' src = '"+src+"' /></td><th>"+rider.first_name + " " + rider.last_name +"</th><td><input type = 'number' class = 'form-control orders' name='orders[]' value='"+orders+"'/></td><td><textarea name = 'comments[]' class = 'form-control' rows='1'>"+rider.comments+"</textarea></td></tr>";
		});
		$table += "</table></form>";

		return $table;
	}
</script>
@endsection
