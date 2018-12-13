@extends('layouts.dashboard')

@section('title', 'Edit Rider')

@section('css')
<link href="{{ asset('dashboard/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/bootstrap-validator/bootstrapValidator.min.css') }}">
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

				{!! Form::model($rider, ['id' => 'employee-form', 'url' => route('update-rider', $rider->id), 'files' => true]) !!}
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