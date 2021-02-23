<!DOCTYPE html>
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>Conquer | Data Tables - Basic Tables</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="MobileOptimized" content="320">
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN THEME STYLES -->
	<link href="{{ asset('assets/css/style-conquer.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/style-responsive.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/plugins.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/themes/default.css')}}" rel="stylesheet" type="text/css" id="style_color" />
	<link href="{{ asset('assets/css/custom.css')}}" rel="stylesheet" type="text/css" />

	<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}" />
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" />
	<style>
		.required:after {
			content: " *";
			color: red;
		}
	</style>
	@yield('javascript')
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->

<body class="page-header-fixed">

	<!-- BEGIN HEADER -->

	<div class="header navbar navbar-fixed-top">
		<div class="header-inner">
			<!-- <center><p>DAFTAR SURAT KELUAR</p>	</center> -->
			@yield('tempat_judul')
		</div>
	</div>
	<!-- BEGIN CONTAINER -->
	<div class="page-container">
		<!-- BEGIN CONTENT -->
		<div class="page-content-wrapper">
			<div class="page-content">
				<!-- menyediakan rumah konten -->
				@yield('tempat_konten')
			</div>
		</div>
		<!-- END CONTENT -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
	<!-- BEGIN CORE PLUGINS -->
	<script src="{{ asset('assets/plugins/jquery-1.11.0.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-migrate-1.2.1.min.js')}}" type="text/javascript"></script>
	<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
	<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>


	<script type="text/javascript" src="{{ asset('assets/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>
	<!-- END CORE PLUGINS -->
	<script src="{{ asset('assets/scripts/app.js')}}"></script>
	<script>
		jQuery(document).ready(function() {
			// initiate layout and plugins
			App.init();
		});
	</script>

	@yield('tempat_script')

</body>
<!-- END BODY -->

</html>