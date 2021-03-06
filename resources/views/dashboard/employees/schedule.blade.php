@extends('layouts.dashboard')

@section('title', 'Rider Off Days Scheduling')

@section('css')
<link href="{{ asset('dashboard/plugins/fullcalendar/v3.9/fullcalendar.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/plugins/fullcalendar/nifty-skin/fullcalendar-nifty.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/css/demo/nifty-demo.min.css') }}"> --}}
@endsection

@section('content')
<div class="panel">
    <div class="panel-body">
        <div class="fixed-fluid">
            <div class="fixed-sm-300 pull-sm-left fixed-right-border">
                <button class="btn btn-block btn-purple btn-md" data-title = "Add Rider Schedule" data-toggle = "modal" data-target="#add-event-modal">Add Rider Off Schedule</button>

                <div id="riders">
                  <div class="list-group bg-trans pad-ver bord-ver">
                    <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Calendar Legend</p>

                    <p class="list-group-item list-item-sm"><span class="badge badge-purple badge-icon badge-fw pull-left"></span> Off Day</p>
                    <p class="list-group-item list-item-sm"><span class="badge badge-danger badge-icon badge-fw pull-left"></span> Leave Day</p>
                  </div>
                </div>

                <p class="pad-hor mar-top text-main text-bold text-sm text-uppercase">Report</p>
                <div class="pad-hor">
                	<div class="form-group">
						{{ Form::label('duration', 'Duration') }}
						{{ Form::select('duration', ['this-week' => 'This Week', 'last-week' => 'Last Week' , 'this-month' => 'This Month'], null, ['class' => 'form-control']) }}
					</div>
					<div class="form-group">
						{{ Form::checkbox('send-email', 'send', true) }}
						{{ Form::label('send-email', 'Send me and email') }}
					</div>

					<div class="form-group">
						{{ Form::label('format', 'Format', ['class' => 'control-label']) }}<br/>
						{{ Form::radio('format', 'image') }} {{ Form::label('Image') }} {{ Form::radio('format', 'pdf', true) }} {{ Form::label('pdf', 'PDF') }}
					</div>
					<button class="btn btn-primary btn-md btn-block" id="generate-report">Generate Report</button>
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
      {{ Form::hidden('id', null) }}
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
        <button class="btn btn-danger pull-left" type="button" id="delete-schedule">Delete Schedule?</button>
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
<script src="{{ asset('dashboard/plugins/fullcalendar/v3.9/fullcalendar.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<!--Full Calendar [ SAMPLE ]-->
<!-- <script src="{{ asset('dashboard/js/demo/misc-fullcalendar.js') }}"></script> -->
<script type="text/javascript">
var calendar;
var datePicker;
  $(document).ready(function(){
    $('#error-alert').hide();
   datePicker = $('#demo-dp-range .input-daterange').datepicker({
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
          $('#add-event-modal').modal('hide');
          calendar.fullCalendar('refetchEvents');
        },
        error: function(jqXHR, status, error){
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
        right: 'listWeek,month'
      },
      defaultView: 'listWeek',
      editable: false,
      events: '/api/riders/schedule/',
      eventClick: function(event, jsEvent, view){
        openModal(event);
      }
    });

    $('#add-event-modal').on('hide.bs.modal', function(event){
        // var modal = $(this);
        // idInput = modal.find('input[name="id"]');
        // riderSelect = modal.find('select[name="rider_id"]');
        // typeSelect = modal.find('select[name="type"]');
        // fromText = modal.find('input[name="from"]');
        // toText = modal.find('input[name="to"]')
        // notes = modal.find('textarea[name="notes"]');

        // idInput.val("");
        // riderSelect.val(null);
        // typeSelect.val(null);
        // fromText.val("");
        // toText.val("");
        // notes.val("");
      
    });

    $('#generate-report').click(function(){
		var duration = $('select[name="duration"]').val();
		var send_email = $('input[name="send-email"]').prop('checked');
		var format = $('input[name="format"]').val();

		var url = "{{ route('schedule-report') }}" + "?duration="+duration+"&email="+send_email+"&format="+format;
		window.location = url;
	});


    $('#add-event-modal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var title = button.data('title');
      if(title){
        var modal = $(this);

        $('#delete-schedule').hide();
        modal.find('.modal-title').text(title);

        idInput = modal.find('input[name="id"]');
        riderSelect = modal.find('select[name="rider_id"]');
        typeSelect = modal.find('select[name="type"]');
        fromText = modal.find('input[name="from"]');
        toText = modal.find('input[name="to"]')
        notes = modal.find('textarea[name="notes"]');

        idInput.val("");
        riderSelect.val(null);
        typeSelect.val(null);
        fromText.val("");
        toText.val("");
        notes.val("");
      }else{
        $('#delete-schedule').show();
      }
    });
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
          event = {
            title: event.rider.first_name + " " + event.rider.last_name,
            start: new Date(event.from),
            end: new Date(event.to),
            allDay: true,
            className: (event.type == "off") ? "purple" : "danger"
          };

          events.push(event);
        });
        calendar.fullCalendar('renderEvents', events);
    },
    error: function(){
        $('body').unblock();
        toastr.error("There was an error getting fetching this month's data", "Oops! There was an error");
    }
  });
}

function openModal(data){
  var modal = $('#add-event-modal');
  modal.modal('show');

  modal.find('.modal-title').text('Editing Schedule');

  idInput = modal.find('input[name="id"]');
  riderSelect = modal.find('select[name="rider_id"]');
  typeSelect = modal.find('select[name="type"]');
  fromText = modal.find('input[name="from"]');
  toText = modal.find('input[name="to"]')
  notes = modal.find('textarea[name="notes"]');

  idInput.val(data.id);
  riderSelect.val(data.rider_id);
  typeSelect.val(data.type);
  fromText.val(moment(data.dates.from).format('MMMM D, YYYY'));
  toText.val(moment(data.dates.to).format('MMMM D, YYYY'));
  notes.val(data.notes);

  $('#demo-dp-range .input-daterange').datepicker('destroy');

  datePicker = $('#demo-dp-range .input-daterange').datepicker({
      format: 'MM dd, yyyy',
      todayBtn: 'linked',
      autoclose: true,
      todayHighlight: true
  });
$('#delete-schedule').click(function(){
	swal({
		title: "Are you sure?",
		text: "Once deleted, you will not be able to recover this schedule!",
		icon: "warning",
		buttons: {
			cancel: "Cancel",
			willDelete: {
				text: "Yes, Delete!",
				closeModal: false,
			},
		},
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				url: '/api/riders/schedule/' + data.id,
				method: 'DELETE',
				success: function(res){
					swal("Deleted!", "Successfully deleted the schedule!", "success");
					$('#add-event-modal').modal('hide');
					calendar.fullCalendar('refetchEvents')
				},
				error: function(){
					swal("Error!", "There was an error processing your request!", "error");
				}
			});
		}
	});
});

  // console.log(datePicker.datepicker('update', [data.dates.from, data.dates.to]));
}
</script>
@endsection
