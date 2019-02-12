@extends('layouts.dashboard')
@section('custom_head')
<div class="pad-all text-center">
    <h3>Welcome back to the Dashboard.</h3>
    <p1>Scroll down to see quick links and overviews of the riders among other helpful information about Tumanisha.<p></p>
    </p1>
</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Order Information</h3>
                </div>
                <div class="pad-all">
                    <div id="orders-chart" style="height: 255px;"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="text-semibold text-uppercase text-main">TOTAL ORDERS</p>
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="media">
                                        <div class="media-left">
                                            <span class="text-3x text-thin text-main">{{ number_format($totalOrders) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <p>
                                        <span>This Month's Numbers</span>
                                        <span class="pad-lft text-semibold">
                                            <span class="text-lg">{{ $thisMonthOrders }}</span>
                                            <span class="labellabel-success mar-lft">
                                                @if ($thisMonthOrders - $lastMonthNumbers < 0)
                                                    <i class="pci-caret-down text-danger"></i> 
                                                @else
                                                    <i class="pci-caret-up text-success"></i>
                                                @endif
                                                <small>@if(@lastMonthNumbers > 0){{ ceil((($thisMonthOrders - $lastMonthNumbers) / $lastMonthNumbers) * 100) }}@else 0 @endif%</small>
                                            </span>
                                        </span>
                                    </p>
                                    <p>
                                        <span>Last Month's Numbers</span>
                                        <span class="pad-lft text-semibold">
                                            <span class="text-lg">{{ $lastMonthNumbers }}</span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <p class="text-uppercase text-semibold text-main">Average Orders</p>
                            <ul class = "list-unstyled">
                                <li>
                                    <div class="media pad-btm">
                                        <div class="media-left">
                                            <span class="text-3x text-thin text-main">{{ ceil(\App\RiderNumber::avg('orders')) }}</span>
                                        </div>
                                        <div class="media-body">
                                            <p class="mar-no">Per Day</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="pad-all">

                    </div>
                </div>
            </div>
         </div>
         <div class="col-lg-5">
             <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="panel">
                        <div class="panel-body text-center">
                            @if($thisMonthChampion != null)
                            <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="{{ $thisMonthChampion->rider->rider_avatar }}">
                            <p class="text-muted ">This Month's Champion</p>
                            <p class="text-normal text-semibold mar-no text-main">{{ $thisMonthChampion->rider->name }} ({{$thisMonthChampion->orders}})</p>
                            @else
                            <img alt="Profile Picture" class="img-lg mar-btm" src="{{ asset('dashboard/img/champion.svg') }}">
                            <p class="text-muted">This Month's Champion</p>
                            <p class="text-normal text-semibold mar-no text-main">No sufficient data</p>
                            @endif
                        </div>
                    </div>
                </div>
                 <div class="col-sm-6 col-lg-6">
                    <div class="panel">
                        <div class="panel-body text-center">
                            @if($lastMonthChampion != null)
                            <img alt="Profile Picture" class="img-lg img-circle mar-btm" src="{{ $lastMonthChampion->rider->rider_avatar }}">
                            <p class="text-muted ">Last Month's Champion</p>
                            <p class="text-normal text-semibold mar-no text-main">{{ $lastMonthChampion->rider->name }} ({{$lastMonthChampion->orders}})</p>
                            @else
                            <img alt="Profile Picture" class="img-lg mar-btm" src="{{ asset('dashboard/img/champion.svg') }}">
                            <p class="text-normal text-semibold mar-no text-main">No sufficient data to get champion</p>
                            <p class=""></p>
                            @endif
                        </div>
                    </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-sm-12 col-lg-12">
                     <div class="panel">
                        <div class="pad-all">
                            <div id="top5riders" style="height: 300px;"></div>
                        </div>
                     </div>
                 </div>
             </div>
         </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/highcharts/code/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/momentjs/moment.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        blockObj.message = foldingLoader;
        $.ajax({
            method: "GET",
            url: "/api/riders/numbers/8months",
            beforeSend: function(){
                $('#orders-chart').block(blockObj);
            },
            success: function(res){
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
                $('#orders-chart').unblock();
                toastr.error("There was an error", "Whoops!");
            }
        });

        $.ajax({
            method: "GET",
            url: "/api/riders/top5",
            beforeSend: function(){
                $('#top5riders').block(blockObj);
            },
            success: function(res){
                data = {};
                data.categories = [];
                data.data = [];
                $.each(res, function(k,v){
                    // console.log(v.employee_id, v.rider);
                    // var month = moment(v.month, "MMMM YYYY").format('MMM');
                    data.categories.push(v.rider.first_name + " " + v.rider.last_name);
                    data.data.push(parseInt(v.orders));
                });

                getTop5Riders(data);
            },
            error: function(){
                $('#top5riders').unblock();
                toastr.error("There was an error", "Whoops!");
            }
        });
    });
    
    function drawLast8MonthsChart(data){
        // categories = [];
        // data = [];
        // for (var i = 1; i <= 8; i++) {
        //  categories.push(i);
        // }

        // for (var i = 1; i <= 8; i++) {
        //  data.push(Math.ceil(Math.random() * (30-0) + 0));
        // }
        Highcharts.chart('orders-chart', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Order Count'
            },
            subtitle: {
                text: 'Last 8 Months'
            },
            legend: {
                enabled: false
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

    function getTop5Riders(data){
        console.log(data);
        Highcharts.chart('top5riders', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Order Count'
            },
            subtitle: {
                text: 'Top 5 Riders'
            },
            legend: {
                enabled: false
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
                enabled: false,
                headerFormat: '<span style="font-size:10px">{point.y}</span><table>',
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
                },
                series: {
                    cursor: 'pointer',
                    point: {
                        events:{
                            click: function(){
                                
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Orders',
                data: data.data
            }]
        });
    }
</script>
@endsection
