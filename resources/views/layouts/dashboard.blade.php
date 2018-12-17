<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ config('app.name') }}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="description" content="Tumanisha Logistics Backend">
	<meta name="author" content="Tumanisha Logistics, tumanisha.co.ke">

	<link rel="icon" href="favicon.ico" type="image/x-icon">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>

	<link href="{{ asset('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('node_modules/toastr/build/toastr.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('dashboard/plugins/spinkit/css/spinkit.min.css') }}">

	<link href="{{ asset('dashboard/css/nifty.min.css') }}" rel="stylesheet">
	<link href="{{ asset('dashboard/css/demo/nifty-demo-icons.min.css') }}" rel="stylesheet">

	<link href="{{ asset('dashboard/plugins/pace/pace.min.css') }}" rel="stylesheet">
	<script src="{{ asset('dashboard/plugins/pace/pace.min.js') }}"></script>

	<link href="{{ asset('dashboard/css/demo/nifty-demo-icons.min.css') }}" rel="stylesheet">


	@yield('css')
</head>
<body>
	<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
	<div id="container" class="effect aside-float aside-bright mainnav-lg">
		<header id="navbar">
			<div id="navbar-container" class="boxed">
				<div class="navbar-header">
					<a class="navbar-brand" href="/">
						<img src="{{ asset('tumanisha-bird.png') }}" alt="Tumanisha Logo" class="brand-icon">
						<div class="brand-title">
							<span class="brand-text">Tumanisha</span>
						</div>
					</a>
				</div>


				<div class="navbar-content">
					<ul class="nav navbar-top-links">
						<li class="tgl-menu-btn">
							<a class="mainnav-toggle" href="#">
								<i class="demo-pli-list-view"></i>
							</a>
						</li>

						<li>
							<div class="custom-search-form">
								<label class="btn btn-trans" for="search-input" data-toggle="collapse" data-target="#nav-searchbox">
									<i class="demo-pli-magnifi-glass"></i>
								</label>
								<form>
									<div class="search-container collapse" id="nav-searchbox">
										<input id="search-input" type="text" class="form-control" placeholder="Type for search...">
									</div>
								</form>
							</div>
						</li>
					</ul>

					<ul class="nav navbar-top-links">
						<li id="dropdown-user" class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
								<i class="demo-pli-user"></i>
								<span class="ic-user pull-right">
									<i class="demo-pli-male"></i>
								</span>
							</a>

							<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right panel-default">
								<ul class="head-list">
									<li>
										<a href="#"><i class="demo-pli-male icon-lg icon-fw"></i> Profile</a>
									</li>
									<li>
										<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="demo-pli-unlock icon-lg icon-fw"></i> Log Out</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</header>

		<div class="boxed">
			<div id="content-container">
				<div id="page-head">
					<div id="page-title">
						<h1 class="page-header text-overflow">@yield('title')</h1>
					</div>

					<!-- <ol class="breadcrumb">
						<li><a href="/"><i class="demo-pli-home"></i></a></li>
						<li class="active">@yield('title')</li>
					</ol> -->
				</div>

				<div id="page-content">
					@if ($errors->any())
					<div class="alert alert-danger">
						<p>There was an error while adding your asset</p>
						<ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@yield('content')
				</div>
			</div>

			<nav id="mainnav-container">
				<div id="mainnav">
					<div id="mainnav-menu-wrap">
						<div class="nano">
							<div class="nano-content">
								<div id="mainnav-profile" class="mainnav-profile">
									<div class="profile-wrap text-center">
										<div class="pad-btm">
											<img class="img-circle img-md" src="{{ asset('dashboard/img/profile-photos/1.png') }}" alt="Profile Picture">
										</div>
										<a href="#profile-nav" class="box-block" data-toggle="collapse" aria-expanded="false">
											<span class="pull-right dropdown-toggle">
												<i class="dropdown-caret"></i>
											</span>
											<p class="mnp-name">{{ Auth::user()->name }}</p>
											<span class="mnp-desc">{{ Auth::user()->email }}</span>
										</a>
									</div>

									<div id="profile-nav" class="collapse list-group bg-trans">
										<a href="#" class="list-group-item">
											<i class="demo-pli-male icon-lg icon-fw"></i> View Profile
										</a>
										<a href="#" class="list-group-item">
											<i class="demo-pli-unlock icon-lg icon-fw"></i> Logout
										</a>
									</div>
								</div>

								<ul id="mainnav-menu" class="list-group">
									<li class="list-header">Navigation</li>
									<li>
										<a href="/">
											<i class="demo-pli-home"></i>
											<span class="menu-title">Dashboard</span>
										</a>
									</li>

									<li class="list-divider"></li>
									@if(Auth::user()->user_role == "admin")
									<li class="list-header">Administration</li>
									<li>
										<a href="#">
											<i class="fa fa-motorcycle"></i>
											<span class="menu-title">Assets</span>
											<i class="arrow"></i>
										</a>
										<ul class="collapse">
											<li><a href="{{ route('assets-home') }}">Manage Assets</a></li>
										</ul>
									</li>

									<li class="list-divider"></li>
									@endif
									@if(Auth::user()->user_role == "admin" || Auth::user()->user_role == "finance")
									<li class="list-header">Finance</li>
									<li>
										<a href="{{ route('invoices_home') }}">
											<i class="demo-pli-file"></i>
											<span class="menu-title">Invoices</span>
										</a>
									</li>

									<li class="list-divider"></li>
									@endif
									@if(Auth::user()->user_role == "admin" || Auth::user()->user_role == "hr")
									<li class="list-header">Human Resource</li>
									<li>
										<a href="{{ route('riders-list') }}">
											<i class="demo-pli-male"></i>
											<span class="menu-title">Employees</span>
										</a>
									</li>

									<li>
										<a href="{{ route('rider-numbers') }}">
											<i class="fa fa-line-chart"></i>
											<span class="menu-title">Rider Numbers</span>
										</a>
									</li>

									<li>
										<a href="{{ route('rider-off-days') }}">
											<i class="demo-pli-calendar-4"></i>
											<span class="menu-title">Rider Weekly Off Schedule</span>
										</a>
									</li>
									@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
		</div>

		<footer id="footer">
			<div class="hide-fixed pull-right pad-rgt">
				Built and designed by <strong>Debech Labs</strong>
			</div>
			<p class="pad-lft">&#0169; <?= @date('Y'); ?> Tumanisha</p>
		</footer>

		<button class="scroll-top btn">
			<i class="pci-chevron chevron-up"></i>
		</button>

	</div>
	@yield('modal')
	<!-- Javascript -->
	<script type="text/javascript" src="{{ asset('dashboard/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('node_modules/toastr/build/toastr.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/js/jquery.blockUI.js') }}"></script>
	<script type="text/javascript" src="{{ asset('dashboard/plugins/sweetalert/sweetalert.min.js') }}"></script>
	@if(session()->has('success'))
	<script type="text/javascript">
		toastr.success("{{ session()->get('success') }}", "Success");
	</script>
	@elseif(session()->has('error'))
	<script type="text/javascript">
		toastr.error("{{ session()->get('error') }} ", "Error");
	</script>@endif
	<script type="text/javascript">
	var pulseLoader = '<div class="sk-spinner sk-spinner-pulse"></div>';
	var cubesLoader = '<div class="sk-wandering-cubes"><div class="sk-cube sk-cube1"></div><div class="sk-cube sk-cube2"></div></div>'

	var blockObj = {
		baseZ: 10000,
		message: cubesLoader,
		css:  {
			border: 'none',
			padding: '15px',
			backgroundColor: 'none',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			color: '#fff'
		}
	}
		$(document).ready(function(){
			$('.table-responsive').on('show.bs.dropdown', function () {
				$('.table-responsive').css( "overflow", "inherit" );
			});

			$('.table-responsive').on('hide.bs.dropdown', function () {
				$('.table-responsive').css( "overflow", "auto" );
			});
		});
	</script>
	@yield('js')
	<script type="text/javascript" src="{{ asset('dashboard/js/nifty.min.js') }}"></script>

	<!-- <script type="text/javascript" src="{{ asset('dashboard/js/demo/nifty-demo.min.js') }}"></script> -->
</body>
</html>
