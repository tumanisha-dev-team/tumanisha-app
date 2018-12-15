@extends('layouts.dashboard')

@section('title', 'New Rider')

@section('css')
<link href="{{ asset('dashboard/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-validator/bootstrapValidator.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<div class="panel">
	<div class="eq-height clearfix">
		<div class="col-md-4 eq-box-md text-center box-vmiddle-wrap bord-hor">
			<div class="box-vmiddle pad-all">
				<h3 class="text-main">Add a Rider</h3>
				<div class="pad-ver">
					 <i class="demo-pli-male icon-5x"></i>
				</div>
				<!-- <div>
					<img id="rider-image" style="width: 100%;max-width: 100%;" src="{{ asset('dashboard/img/gallery/big/tile10.jpg') }}" />
				</div> -->
				<ul>
					<li>Please make sure you fill in all the sections as required.</li>
					<li>Missing information may lead to data loss.</li>
				</ul>
			</div>
		</div>
		<div class="col-md-8 eq-box-md eq-no-panel">
			<div id="demo-main-wz">
				<!-- <ul class="row wz-step wz-icon-bw wz-nav-off mar-top">
					<li class="col-xs-3">
						<a data-toggle="tab" href="#employee-profile">
							<span class="text-danger"><i class="demo-pli-information icon-2x"></i></span>
							<h5 class="mar-no">Employee Profile</h5>
						</a>
					</li> -->

					<!-- <li class="col-xs-3">
						<a data-toggle="tab" href="#education-history">
							<span class="text-success"><i class="fa fa-graduation-cap fa-2x"></i></span>
							<h5 class="mar-no">Education History</h5>
						</a>
					</li>

					<li class="col-xs-3">
						<a data-toggle="tab" href="#work-experience">
							<span class="text-primary"><i class="fa fa-suitcase fa-2x"></i></span>
							<h5 class="mar-no">Work Experience</h5>
						</a>
					</li>

					<li class="col-xs-3">
						<a data-toggle="tab" href="#next-of-kin">
							<span class="text-warning"><i class="ion ion-person-stalker icon-2x"></i></span>
							<h5 class="mar-no">Next of Kin</h5>
						</a>
					</li> -->
				<!-- </ul> -->

				<!-- <div class="progress progress-xs">
					<div class="progress-bar progress-bar-primary"></div>
				</div> -->

				{!! Form::open(['id' => 'employee-form', 'url' => route('post-new-rider'), 'files' => true]) !!}
					<div class="panel-body">
						<!-- <div class="tab-content"> -->
							<div id="employee-profile" class="tab-pane">
								<fieldset>
									<legend>Basic Information</legend>
									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('first_name', 'First Name', ['class' => 'control-label']) !!}
											{!! Form::text('first_name', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('last_name', 'Last Name', ['class' => 'control-label']) !!}
											{!! Form::text('last_name', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('national_id_no', 'National ID No.', ['class' => 'control-label']) !!}
											{!! Form::text('national_id_no', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('license_no', 'Driving License No.', ['class' => 'control-label']) !!}
											{!! Form::text('license_no', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('kra_pin', 'KRA PIN', ['class' => 'control-label']) !!}
											{!! Form::text('kra_pin', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('nhif_no', 'NHIF No.', ['class' => 'control-label']) !!}
											{!! Form::text('nhif_no', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('date_of_birth', 'Birth Date', ['class' => 'control-label']) !!}
											{!! Form::date('date_of_birth', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('gender', 'Gender', ['class' => 'control-label']) !!}
											{!! Form::select('gender', [0 => 'Male', 1 => 'Female'], NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('nationality', 'Nationality', ['class' => 'control-label']) !!}
											{!! Form::text('nationality', 'Kenyan', ['class' => 'form-control', 'readonly' => 'readonly']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('religion', 'Religion', ['class' => 'control-label']) !!}
											{!! Form::select('religion', $religions, NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('primary_phone_number', 'Primary Phone Number', ['class' => 'control-label']) !!}
											{!! Form::text('primary_phone_number', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('secondary_phone_number', 'Secondary Phone Number', ['class' => 'control-label']) !!}
											{!! Form::text('secondary_phone_number', NULL, ['class' => 'form-control']) !!}
											<small class="help-block">Optional</small>
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
											{!! Form::email('email', NULL, ['class' => 'form-control']) !!}
										</div>

										<div class="col-lg-6">
											{!! Form::label('image', 'Upload the Rider\'s passport photo', ['class' => 'control-label']) !!}
											{!! Form::file('image', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>


								</fieldset>

								<fieldset>
									<legend>Physical Information</legend>
									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('height', 'Height', ['class' => 'control-label']) !!}
											{!! Form::number('height', NULL, ['class' => 'form-control']) !!}
										</div>
										<div class="col-lg-6">
											{!! Form::label('eye_color', 'Eye Color', ['class' => 'control-label']) !!}
											{!! Form::text('eye_color', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('hair_color', 'Hair Color', ['class' => 'control-label']) !!}
											{!! Form::text('hair_color', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>
								</fieldset>
								
								<fieldset>
									<legend>HR Information</legend>
									<div class="form-group">
										<div class="col-lg-6">
											{!! Form::label('starting_date', 'Official Starting Date', ['class' => 'control-label']) !!}
											{!! Form::text('starting_date', NULL, ['class' => 'form-control']) !!}
										</div>
									</div>
								</fieldset>
							</div>

							<!-- <div id="education-history" class="tab-pane">
								<div class="form-group">
									{!! Form::label('college_high_schoool', 'High School/College') !!}
									{!! Form::text('college_high_school', NULL, ['class' => 'form-control']) !!}
								</div>

								<div class="form-group">
									{!! Form::label('primary_school', 'Primary School') !!}
									{!! Form::text('primary_school', NULL, ['class' => 'form-control']) !!}
								</div>
							</div> -->

							<!-- <div id="work-experience" class="tab-pane">
								<div id="work-experience-template-holder">
									<div class="work-experience-template bord-all pad-all mar-btm" id="experience_0" data-id = "0">
										<div class="form-group mar-btm">
											<div class="col-lg-6">
												{!! Form::label('company', 'Company Name', ['class' => 'control-label']) !!}
												{!! Form::text('company[]', NULL, ['class' => 'form-control']) !!}
											</div>
											<div class="col-lg-6">
												{!! Form::label('role', 'Role', ['class' => 'control-label']) !!}
												{!! Form::text('role[]', NULL, ['class' => 'form-control']) !!}
											</div>
										</div>
										<div class="form-group mar-top">
											<label class="control-label">Referees</label>
											<table class="table table-vcenter">
												<thead>
													<th>#</th>
													<th>Name</th>
													<th>Phone</th>
													<th>Email</th>
													<th></th>
												</thead>
												<tbody class="referee_content">
													<tr class="referee_rows">
														<td>1</td>
														<td class="referee_name">{!! Form::text('referee_name[0][]', NULL, ['class' => 'form-control']) !!}</td>
														<td class="referee_contact">{!! Form::text('referee_contact[0][]', NULL, ['class' => 'form-control']) !!}</td>
														<td class="referee_email">{!! Form::email('referee_email[0][]', NULL, ['class' => 'form-control']) !!}</td>
														<td><a class="btn btn-danger btn-xs remove-referee"><i class="fa fa-minus"></i>&nbsp;&nbsp;Remove Referee</a></td>
													</tr>
												</tbody>
											</table>
										</div>
										
										<div class="text-right">
											<a class="btn btn-xs btn-default add-referee"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Referee</a>
											<a class="btn btn-xs btn-danger remove-experience"><i class="fa fa-minus"></i>&nbsp;&nbsp;Remove Experience</a>
										</div>
									</div>
								</div>

								<a class="btn btn-default btn-xs" id="add-experience" role="button"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Experience</a>
							</div> -->

							<!-- <div id="next-of-kin" class="tab-pane">
								<div id="next-of-kin-template">
									<div class="nextkin bord-all pad-all mar-btm">
										<div class="row form-group mar-btm">
											<div class="col-md-6">
												{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
												{!! Form::text('name', NULL, ['class' => 'form-control']) !!}
											</div>
											<div class="col-md-6">
												{!! Form::label('contact', 'Phone Number', ['class' => 'control-label']) !!}
												{!! Form::text('contact', NULL, ['class' => 'form-control']) !!}
											</div>
										</div>

										<div class="text-right">
											<a class="btn btn-xs btn-danger remove-kin"><i class="fa fa-minus"></i>&nbsp;&nbsp;Remove Next of Kin</a>
										</div>
									</div>
									
								</div>

								<div class="text-right">
									<a class="btn btn-xs btn-default add-kin"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Next of Kin</a>
								</div>
							</div> -->
						<!-- </div> -->
					</div>

					<!-- <div class="pull-right pad-rgt mar-btm">
						<button type="button" class="previous btn btn-primary">Previous</button>
						<button type="button" class="next btn btn-primary">Next</button>
						<button type="button" class="finish btn btn-success" disabled>Finish</button>
					</div> -->
					<div class="pull-right pad-rgt mar-btm">
						<button id="save-btn" type="submit" class="btn btn-success">Save</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('dashboard/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('dashboard/plugins/bootstrap-validator/bootstrapValidator.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
	var referee_template = "";
	var nextofkin_template = "";
	$(document).ready(function(){
		starting_date = $('input[name="starting_date"]').datepicker({
			format: 'MM dd, yyyy',
			clearBtn: true,
			disableTouchKeyboard: true,
			autoclose: true,
			todayHighlight: true,
			setDate: new Date()
		});
		var experience_template = $('#work-experience-template-holder').first().html();
		referee_template = $('.referee_content').html();
		nextofkin_template = $('#next-of-kin-template').html();
		$('#demo-main-wz').bootstrapWizard({
			tabClass		: 'wz-steps',
			nextSelector	: '.next',
			previousSelector	: '.previous',
			onTabClick: function(tab, navigation, index) {
				return false;
			},
			onInit : function(){
				$('#demo-main-wz').find('.finish').hide().prop('disabled', true);
			},
			onTabShow: function(tab, navigation, index) {
				var $total = navigation.find('li').length;
				var $current = index+1;
				var $percent = ($current/$total) * 100;
				var wdt = 100/$total;
				var lft = wdt*index;

				$('#demo-main-wz').find('.progress-bar').css({width:wdt+'%',left:lft+"%", 'position':'relative', 'transition':'all .5s'});


				// If it's the last tab then hide the last button and show the finish instead
				if($current >= $total) {
					$('#demo-main-wz').find('.next').hide();
					$('#demo-main-wz').find('.finish').show();
					$('#demo-main-wz').find('.finish').prop('disabled', false);
				} else {
					$('#demo-main-wz').find('.next').show();
					$('#demo-main-wz').find('.finish').hide().prop('disabled', true);
				}
			},
			onNext: function(){
				isValid = null;
	            $('#employee-form').bootstrapValidator('validate');

	            if(isValid === false)return false;
			},
			onFinish: function(){
				alert("Finish alert called");
			}
		});

		var isValid;

		$('#save-btn').click(function(){
			// alert("save button");
		});

		$('#employee-form').bootstrapValidator({
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'fa fa-check-circle fa-lg text-success',
				invalid: 'fa fa-times-circle fa-lg',
				validating: 'fa fa-refresh'
			},
			fields: {
				first_name: {
					message: "First name is not valid",
					validators: {
						notEmpty: {
							message: 'First name is required.'
						}
					}
				},
				last_name: {
					message: "Last name is not valid",
					validators: {
						notEmpty: {
							message: 'Last name is required.'
						}
					}
				},
				national_id_no: {
					message: "National ID Number is not valid",
					validators: {
						notEmpty: {
							message: 'National ID Number is required.'
						}
					}
				},
				license_no: {
					message: "License Number is not valid",
					validators: {
						notEmpty: {
							message: 'License Number is required.'
						}
					}
				},
				kra_pin: {
					message: "KRA PIN is not valid",
					validators: {
						notEmpty: {
							message: 'KRA PIN is required.'
						}
					}
				},
				date_of_birth: {
					message: "Date of Birth is not valid",
					validators: {
						notEmpty: {
							message: 'Date of Birth is required.'
						}
					}
				},
				primary_phone_number: {
					message: "Primary Phone Number is not valid",
					validators: {
						notEmpty: {
							message: 'Primary Phone Number is required.'
						}
					}
				},
				email: {
					message: "Email address is not valid",
					validators: {
						notEmpty: {
							message: 'Email address is required.'
						}
					}
				},
				height: {
					message: "Height is not valid",
					validators: {
						notEmpty: {
							message: 'Height is required.'
						}
					}
				},
				eye_color: {
					message: "Eye color is not valid",
					validators: {
						notEmpty: {
							message: 'Eye color is required.'
						}
					}
				},
				hair_color: {
					message: "Hair color is not valid",
					validators: {
						notEmpty: {
							message: 'Hair color is required.'
						}
					}
				}
			}
		}).on('success.field.bv', function(e, data){
			var $parent = data.element.parents('.form-group');
			$parent.removeClass('has-success');
		}).on('error.form.bv', function(e) {
			isValid = false;
		});

		$('.work-experience-template').find('div.form-group').removeClass('has-feedback');

		$('#add-experience').click(function(){
			$('#work-experience-template-holder').append(experience_template);

			refreshExperiences();
		});

		$('#work-experience-template-holder').on('click', 'a.remove-experience', function(){
			experiences = $('.work-experience-template');
			if(experiences.length > 1){
				$(this).parent().parent().remove();

				refreshExperiences();
			}else{
				alert("Cannot remove all experiences. You must have at least one!");
			}
		});

		$('#work-experience-template-holder').on('click', 'a.remove-referee', function(){
			$(this).parent().parent().remove();
		});

		$('#work-experience-template-holder').on('click', 'a.add-referee', function(){
			refreshReferees(this);
		});

		$('.add-kin').click(function(){
			$('#next-of-kin-template').append(nextofkin_template);
		});

		$('#next-of-kin-template').on('click', 'a.remove-kin', function(){
			$kins = $('.nextkin');
			if($kins.length == 1){
				alert("You must have at least 1 next of kin");
			}else{
				$(this).parent().parent().remove();
			}
		});
	});

	function refreshExperiences(){
		experiences = $('.work-experience-template');

		$.each(experiences, function(key, experience){
			var exp = $(experience);
			exp.attr('id', 'experience_' + key);
			exp.attr('data-id', key);
			var referee_rows = exp.find('.referee_rows');
			$.each(referee_rows, function(k, row){
				refreshInput(key, k, row);
			});
		});
	}

	function refreshReferees(that){
		main_parent = $(that).parent().parent();
		var id = main_parent.attr('data-id');
		referee_content = main_parent.find('.referee_content');
		referee_content.append(referee_template);
		rows = referee_content.find('tr');
		$.each(rows, function(k, row){
			refreshInput(id, k, row);
		});
	}

	function refreshInput(id, row_id, row){
		no_column = $(row).find('td').first();
		name_column = $(row).find('td.referee_name');
		email_column = $(row).find('td.referee_email');
		contact_column = $(row).find('td.referee_contact');

		number = row_id + 1;
		no_column.text(number);
		name_column.find('input').attr('name', 'referee_name['+id+'][]');
		email_column.find('input').attr('name', 'referee_email['+id+'][]');
		contact_column.find('input').attr('name', 'referee_contact['+id+'][]');
	}
</script>
@endsection