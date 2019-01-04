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
                <hr>

                <p class="pad-ver text-main text-sm text-uppercase text-bold">About Rider</p>
                <p><i class="demo-pli-calendar-4 icon-lg icon-fw"></i> {{ \Carbon\Carbon::parse($rider->date_of_birth)->format('dS F Y') }}</p>
                <p><i class="demo-pli-old-telephone icon-lg icon-fw"></i> {{ $rider->primary_phone_number }}</p>
                <p><i class="demo-pli-mail icon-lg icon-fw"></i> {{ $rider->email }} </p>

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
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/highcharts/code/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/highcharts/code/modules/drilldown.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/momentjs/moment.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
    	$.ajax({
    		method: "GET",
    		url: "/api/riders/numbers/{{ $rider->id }}/last8Months",
    		beforeSend: function(){
    			console.log("Request started");
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
		
    });

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
</script>
@endsection
