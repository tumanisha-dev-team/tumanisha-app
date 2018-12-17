@extends('layouts.dashboard')

@section('title', 'Rider Off Days Scheduling')

@section('css')
<link href="{{ asset('dashboard/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
            <div class="fixed-sm-300 pull-sm-left fixed-right-border">
                <button class="btn btn-block btn-purple btn-md" data-toggle = "modal" data-target="#add-event-modal">Add Rider Off Schedule</button>

                <div id="riders">
                  <div class="list-group bg-trans pad-ver bord-ver">
                    <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Calendar Legend</p>

                    <p class="list-group-item list-item-sm"><span class="badge badge-purple badge-icon badge-fw pull-left"></span> Off Day</p>
                    <p class="list-group-item list-item-sm"><span class="badge badge-danger badge-icon badge-fw pull-left"></span> Leave Day</p>
                  </div>
                </div>
            </div>
            <div class="fluid">
                <div id = "calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="add-event-modal" role="dialog" tabindex="-1" aria-labelledby="add-event-modal" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><i class="pci-cross pci-circle"></i></button>
				<h4 class="modal-title">Add Rider Schedule</h4>
			</div>
      {{ Form::open(['files' => true, 'url' => '/api/riders/schedule/add', 'id'=>'schedule-form']) }}
      <div class="modal-body">
        <div id="error-alert">
          <div class="alert alert-danger">
              <button class="close" data-dismiss="alert"><i class="pci-cross pci-circle"></i></button>
              <div id="alert-content"></div>
          </div>
        </div>
        <div class="form-group">
            {{ Form::label('rider_id', 'Rider') }}
            {!! Form::select('rider_id', $riders, null, ['class' => 'form-control', 'placeholder' => 'Select the rider']) !!}
        </div>
        <div class="form-group">
            {{ Form::label('type', 'Type') }}
            {!! Form::select('type', ['off' => 'Off Day', 'leave' => 'Leave Day'], null, ['class' => 'form-control', 'placeholder' => 'Select the type']) !!}
        </div>

        <div class="form-group">
            {{ Form::label('schedule_period', 'Period') }}
            <div id="demo-dp-range">
  						<div class="input-daterange input-group" id="datepicker">
  							{{ Form::text('from', null, ['class' => 'form-control', 'required']) }}
  							<span class="input-group-addon">to</span>
  							{{ Form::text('to', null, ['class' => 'form-control', 'required']) }}
  						</div>
  					</div>
        </div>

        <div class="form-group">
            {{ Form::label('notes', 'Notes (Optional)') }}
            {{ Form::textarea('notes', NULL, ['class' => 'form-control', 'rows' => 8]) }}
        </div>
      </div>
      <div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				<button class="btn btn-primary" id="save-schedule">Save changes</button>
			</div>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{ asset('dashboard/plugins/fullcalendar/lib/moment.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/fullcalendar/lib/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!--Full Calendar [ SAMPLE ]-->
<!-- <script src="{{ asset('dashboard/js/demo/misc-fullcalendar.js') }}"></script> -->
<script type="text/javascript">
var calendar;
  $(document).ready(function(){
    $('#error-alert').hide();
    $('#demo-dp-range .input-daterange').datepicker({
        format: 'MM dd, yyyy',
        todayBtn: 'linked',
        autoclose: true,
        todayHighlight: true
  	});

    $('#save-schedule').click(function(e){
      e.preventDefault();

      var form = $('#schedule-form');
      var formData = form.serializeArray();

      $.ajax({
        url: form.attr('action'),
        method: "POST",
        data: formData,
        beforeSend: function(){
          $('body').block(blockObj);
        },
        success: function(res){
          $('body').unblock();
          toastr.success("Successfully added rider to schedule");
        },
        error: function(jqXHR, status, error){
          console.error(jqXHR.responseJSON);
          $('body').unblock();
          toastr.error("There was an error while trying to add the rider to the schedule.\n", "Please try again");
          error_html = "<p>Please handle the following errors:<p><p>"+jqXHR.responseJSON.message+"</p><ul>";
          $.each(jqXHR.responseJSON.errors, function(key, error){
            error_html += "<li>"+error+"</li>";
          });
          error_html += "</ul>";
          $('#error-alert .alert #alert-content').html(error_html);
          $('#error-alert').show();
        }
      });
    });
    calendar = $('#calendar').fullCalendar({
      header: {
        left: 'prev,next,today',
        center: 'title',
        right: 'month'
      },
      editable: false,
      events: '/api/riders/schedule/'
    });

    // getMonthlySchedule();
    // calendar.fullCalendar('renderEvent', {
    //   title: 'Chrispine Otaalo',
    //   start: new Date(),
    //   allDay: true,
    //   className: 'danger'
    // });
  });

function getCurrentCalendarMonth(){
  currentDate = calendar.fullCalendar('getDate');
  currentMonth = currentDate.format('M');

  return currentMonth;
}

function getMonthlySchedule(){
  month = getCurrentCalendarMonth();

  $.ajax({
    url: '/api/riders/schedule/' + month,
    method: 'GET',
    beforeSend: function(){
      $('body').block(blockObj);
    },
    success: function(res){
        $('body').unblock();
        events = [];
        $.each(res, function(key, event){
          console.log(event);
          event = {
            title: event.rider.first_name + " " + event.rider.last_name,
            start: new Date(event.from),
            end: new Date(event.to),
            allDay: true,
            className: (event.type == "off") ? "purple" : "danger"
          };

          events.push(event);
        });
        console.log(events);
        calendar.fullCalendar('renderEvents', events);
    },
    error: function(){
        $('body').unblock();
        toastr.error("There was an error getting fetching this month's data", "Oops! There was an error");
    }
  });
}
</script>
@endsection
