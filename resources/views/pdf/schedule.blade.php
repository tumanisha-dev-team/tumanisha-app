<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link href="{{ public_path('dashboard/css/bootstrap.min.css') }}" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{{ public_path('dashboard/plugins/font-awesome/css/font-awesome.min.css') }}">
	<style type="text/css">
		@page {
		margin: 0cm 0cm;
		}

		/** Define now the real margins of every page in the PDF **/
		body {
		margin-top: 3cm;
		margin-left: 2cm;
		margin-right: 2cm;
		margin-bottom: 2cm;
		}

		/** Define the header rules **/
		header {
		position: fixed;
		top: 0cm;
		left: 0cm;
		right: 0cm;
		height: 3cm;
		}

		/** Define the footer rules **/
		footer {
		position: fixed; 
		bottom: 0cm; 
		left: 0cm; 
		right: 0cm;
		height: 2cm;
		}
		@font-face {
			font-family: 'lato';
			src: url({{ storage_path('fonts/lato/lato/Lato-Regular.ttf') }}) format("truetype");
			font-weight: 400; // use the matching font-weight here ( 100, 200, 300, 400, etc).
			font-style: normal; // use the matching font-style here
		}

		body{
			font-family: "lato";
		}

		.danger{
			background-color: '#f44336';
		}

		.purple{
			background-color: '#ab47bc';
		}

		p{
			padding: 0;
		}
	</style>
</head>
<body>
	<header class="text-muted">
		<img src="{{ public_path('tumanisha-header.png') }}" width="100%" height="100%"/>
		{{-- <span class="pull-left">Tumanisha Logistics</span>
		<span class="pull-right">www.tumanisha.co.ke</span> --}}
	</header>
	<footer class="text-muted">
		<small><center>Generated on: {{ \Carbon\Carbon::now()->format('d/M/Y \a\t h:i a') }}</center></small>
	</footer>
	<main>
		<center>
			<p style="padding: 0;">OFF SCHEDULE</p>
			<p>{{ \Carbon\Carbon::parse($start_date)->format('d/M/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/M/Y') }}</p>
		</center>

		<table class="table table-bordered" style="width: 100%;">
			<tbody>
			@forelse($dates as $date => $schedule)
			<tr class="active">
				<th>{{ \Carbon\Carbon::parse($date)->format('l') }}<span class="pull-right">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</span></th>
			</tr>
			<?php foreach($schedule as $s){ ?>
			<tr>
				<td>{{ $s['rider'] }} (<?php if($s['type'] == 'off'){ echo 'Off'; } else { echo 'Leave'; } ?>)</td>
			</tr>
			<?php } ?>
			@empty

			@endforelse
			</tbody>
		</table>
	</main>
</body>
</html>