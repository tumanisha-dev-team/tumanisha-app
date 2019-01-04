@extends('layouts.dashboard')

@section('title', 'Rider Details')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/highcharts/code/css/highcharts.css') }}">
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
            <div class="fixed-md-200 pull-sm-left fixed-right-border">
                <div class="text-center">
                    <div class="pad-ver">
                        <img src="{{ $rider->rider_avatar }}" class="img-lg img-circle" alt="Profile Picture">
                    </div>
                    <h4 class="text-lg text-overflow mar-no">{{ $rider->first_name }} {{ $rider->last_name }}</h4>
                    <p class="text-sm text-muted">Rider</p>
                </div>
                <hr class="new-section-xs">

                <p class="pad-ver text-main text-sm text-uppercase text-bold">About Rider</p>
                <p><i class="demo-pli-calendar-4 icon-lg icon-fw"></i> {{ \Carbon\Carbon::parse($rider->date_of_birth)->format('dS F Y') }}</p>
                <p><i class="demo-pli-old-telephone icon-lg icon-fw"></i> {{ $rider->primary_phone_number }}</p>
                <p><i class="demo-pli-mail icon-lg icon-fw"></i> {{ $rider->email }} </p>

                <hr class="new-section-xs"/>
				<div class="pad-all">
					<span class="pad-ver text-main text-sm text-uppercase text-bold">Expected Earnings</span>
					<p class="text-sm">{{ \Carbon\Carbon::now()->format('F Y') }}</p>
					<p class="text-2x text-main">KSH. {{ number_format($current_month_numbers * 50) }}</p>
				</div>

            </div>

            <div class="fluid">
                <div class="row mar-top">
                    <div class="col-md-3">
                        <h3 class="text-main text-normal text-2x mar-no">Total Orders</h3>
                        <h5 class="text-uppercase text-muted text-normal">Rider's lifetime report</h5>
                        <hr class="new-section-xs">
                        <div class="text-lg">
                            <p class="text-5x text-thin text-main mar-no">{{ $rider->orders->sum('orders') }}</p>
                        </div>
                        <p class="text-sm">Data from {{ \Carbon\Carbon::parse($rider->orders->min('orders_date'))->format('dS F Y') }} to {{ \Carbon\Carbon::parse($rider->orders->max('orders_date'))->format('dS F Y') }}</p>
                        <hr class="new-section-xs">
                        <div class="text-lg">
                            <p class="text-5x text-thin text-main mar-no">{{ $current_month_numbers }}</p>
                        </div>
                        <h3 class="text-main text-normal text-2x mar-no">This Month</h3>
                    </div>
                    <div class="col-md-9">
                        <div id="demo-bar-chart" style="height:350px"></div>
                    </div>
                </div>
                <hr class="new-section-xs">
                <div class="row" id="rider-monthly-stats" style="max-height: 600px;">
                	<div class="col-md-12">
                		<div class="row form-group">
                			<div class="col-md-4">
                				<select class="form-control" name="month-select">
                					@foreach($months as $month)
                					<option value="{{ $month }}" @if($month == \Carbon\Carbon::now()->format('F')) selected="selected" @endif>{{ $month }}</option>
                					@endforeach
                				</select>
                			</div>

                			<div class="col-md-4">
                				<select class="form-control" name="year-select">
                					@foreach($years as $year)
                					<option value="{{ $year }}" @if($year == \Carbon\Carbon::now()->format('Y')) selected="selected" @endif>{{ $year }}</option>
                					@endforeach
                				</select>
                			</div>

                			<div class="col-md-2">
                				<button class="btn btn-purple" id="search-month-data">Search</button>
                			</div>
                		</div>
                	</div>
                	<div class="col-md-3 pad-all" style="height: 450px;overflow-y: scroll;">
                		<div class="table-responsive">
                			<table class="table table-striped">
                				<thead>
                					<th>Date</th>
                					<th>Orders</th>
                				</thead>
                				<tbody id="orders-table">
                					<tr>
                						<td colspan="2"><center>Data will appear here</center></td>
                					</tr>
                				</tbody>
                			</table>
                		</div>
                		
                	</div>
                	<div class="col-md-9">
                		<div class="row">
                			<div class="col-md-4">
                                <div class="panel media middle pad-all mar-no">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                            <i class="demo-pli-add-cart icon-2x"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p class="text-2x mar-no text-semibold text-main" id="deliveries">0</p>
                                        <p class="text-muted mar-no">Deliveries</p>
                                    </div>
                                </div>
                			</div>

                            <div class="col-md-4">
                                <div class="panel media middle pad-all mar-no">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-danger">
                                            <i class="demo-pli-calendar-4 icon-2x"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p class="text-2x mar-no text-semibold text-main" id="absentDays">0</p>
                                        <p class="text-muted mar-no">Absent Days</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="panel media middle pad-all mar-no">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                            <i class="demo-pli-coin icon-2x"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p class="h4 mar-no text-semibold text-main" id="expectedAmount">KSH 0</p>
                                        <p class="text-muted mar-no">Expected Amount</p>
                                    </div>
                                </div>
                            </div>
                		</div>
                        <hr class="new-section-xs" />
                        <div class="row">
                            <div class="col-md-12">
                                <div id="month-stats" style="height: 400px;"></div>
                            </div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/highcharts/code/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/highcharts/code/modules/drilldown.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/momentjs/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/accounting.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	blockObj.message = foldingLoader;
    	$.ajax({
    		method: "GET",
    		url: "/api/riders/numbers/{{ $rider->id }}/last8Months",
    		beforeSend: function(){
    			$('#demo-bar-chart').block(blockObj);
    		},
    		success: function(res){
    			// toastr.success("There was a response", "Yes!");
    			data = {};
    			data.categories = [];
    			data.data = [];
    			$.each(res, function(k,v){
    				var month = moment(v.month, "MMMM YYYY").format('MMM');
    				data.categories.push(month);
    				data.data.push(v.numbers);
    			});

    			drawLast8MonthsChart(data);
    		},
    		error: function(){
    			toastr.error("There was an error", "Whoops!");
    		}
    	});

    	$('#search-month-data').click(function(){
    		month = $('select[name="month-select"]').val();
    		year = $('select[name="year-select"]').val();

    		getMonthlyData(month, year)
    	});

    	$('#search-month-data').trigger('click');
		
    });

    function getMonthlyData(month, year){
    	$.ajax({
    		url: '/api/riders/numbers/{{ $rider->id }}/month/' + month + '/' + year,
    		beforeSend: function(){
    			$('#rider-monthly-stats').block(blockObj);
    		},
    		success: function(res){
    			$('#rider-monthly-stats').unblock();
    			$('#orders-table').empty();
    			var totalOrders = 0;
    			var absentDays = 0;
                var categories = [];
                var dayNo = [];
    			if (res.length > 0) {
    				$.each(res, function(key, data){
    					formattedOrders = "";
    					if (data.number == "") {
    						formattedOrders = "N/A";
    						totalOrders += 0;
                            if(moment(data.date) <= moment()){
    						  absentDays += 1;
                            }
    					}else{
    						formattedOrders = data.number;
    						totalOrders += data.number;
    					}
                        categories.push(moment(data.date).format('Do'));
                        dayNo.push(formattedOrders);
	    				$('#orders-table').append("<tr><td>"+moment(data.date).format("DD/MM/YYYY")+"</td><td>"+formattedOrders+"</td></tr>");
	    			});
    			}else{
    				$('#orders-table').append("<tr><td colspan='2'><center>There is no data available for this month</center></td></tr>");
    			}

                $('#deliveries').text(totalOrders);
    			$('#absentDays').text(absentDays);
                var expectedAmount = accounting.formatMoney(totalOrders * 50, "KSH ", 0);
                $('#expectedAmount').text(expectedAmount);
                drawMonthNumbers(categories, dayNo, month + " " + year);
    		},
    		error: function(){
    			$('#rider-monthly-stats').unblock();
    		}
    	});
    }

    // function getLast8MonthsData

    function drawLast8MonthsChart(data){
    	// categories = [];
    	// data = [];
    	// for (var i = 1; i <= 8; i++) {
    	// 	categories.push(i);
    	// }

    	// for (var i = 1; i <= 8; i++) {
    	// 	data.push(Math.ceil(Math.random() * (30-0) + 0));
    	// }
		Highcharts.chart('demo-bar-chart', {
			chart: {
				type: 'column'
			},
			title: {
				text: 'Rider Order Count'
			},
			subtitle: {
				text: 'Last 8 Months'
			},
			xAxis: {
				categories: data.categories,
				crosshair: true
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Orders'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y} orders</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: [{
				name: 'orders',
				data: data.data
			}]
		});       
    }

    function drawMonthNumbers(categories, data, month){
        // categories = [];
        // data = [];
        // for (var i = 1; i <= 8; i++) {
        //  categories.push(i);
        // }

        // for (var i = 1; i <= 8; i++) {
        //  data.push(Math.ceil(Math.random() * (30-0) + 0));
        // }
        Highcharts.chart('month-stats', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Rider Order Count'
            },
            subtitle: {
                text: month
            },
            xAxis: {
                categories: categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Orders'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y} orders</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'orders',
                data: data
            }]
        });       
    }
</script>
@endsection
