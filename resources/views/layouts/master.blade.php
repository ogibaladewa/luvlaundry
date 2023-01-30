<!doctype html>
<html lang="en">

<head>
	<title>Dashboard | DiffDash - Free Admin Template</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/linearicons/style.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/metisMenu/metisMenu.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/chartist/css/chartist.min.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/DataTables/datatables.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/vendor/toastr/toastr.min.css')}}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
	<link rel="stylesheet" href="{{asset('admin/assets/css/main.css')}}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{asset('admin/assets/css/demo.css')}}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin/assets/img/apple-icon.png')}}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{asset('admin/assets/img/favicon.png')}}">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		@include('layouts.includes._navbar')
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		@include('layouts.includes._sidebar')
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN CONTENT -->
		@yield('content')
		<!-- END MAIN CONTENT -->
		<div class="clearfix"></div>
		<footer>
			<p class="copyright">&copy; 2020 <a href="" target="_blank">Luv Laundry</a>. All Rights Reserved.</p>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{asset('admin/assets/vendor/jquery/jquery.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/metisMenu/metisMenu.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/jquery-sparkline/js/jquery.sparkline.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/chartist/js/chartist.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/chartist-plugin-axistitle/chartist-plugin-axistitle.min.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/chartist-plugin-legend-latest/chartist-plugin-legend.js')}}"></script>
	<script type="text/javascript" charset="utf8" src="{{asset('admin/assets/DataTables/datatables.js')}}"></script>
	<script src="{{asset('admin/assets/vendor/toastr/toastr.js')}}"></script>
	<script src="{{asset('admin/assets/scripts/common.js')}}"></script>
	
	@yield('script')
	
	
</body>

</html>
